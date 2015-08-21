<?php

namespace RelationFormBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\Expression;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManager;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $request = $this->get('request');
        $jsonResponse = new JsonResponse();

        $entityName = $request->get('entityName');
        $query = $request->get('query');
        $fields = $request->get('fields');

        $jsonResponse->setData(array(
            'entityName' => $entityName,
            'query' => $query,
            'fields' => $fields,
        ));

        $criteria = new Criteria();
        foreach ($query as $field => $str) {
            $expr = new Comparison($field, Comparison::CONTAINS, '%' . $str . '%');
            $criteria->andWhere($expr);
        }

        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.entity_manager');

        try {
            $repository = $em->getRepository($entityName);
            $entities = $repository->matching($criteria);
        } catch (\Exception $e) {
            $kernel = $this->get('kernel');
            $env = $kernel->getEnvironment();
            if ($env == 'dev')
                return $jsonResponse->setData(array('error' => $e->getMessage()));

            return $jsonResponse->setData(array('error' => true));
        }

        $data = array();
        foreach ($entities as $entity) {
            $row = array();
            foreach ($fields as $field) {
                $getter = $this->__getter($field);
                if (method_exists($entity, $getter))
                    $row[$field] = $entity->$getter();
                else
                    $row[$field] = '???';
            }
            $row['_query'] = $query;
            $data[] = $row;
        }

        $jsonResponse->setData($data);

        return $jsonResponse;
    }

    private function __getter($field)
    {
        return 'get' . ucfirst($field);
    }
}
