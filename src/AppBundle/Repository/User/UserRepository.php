<?php
namespace AppBundle\Repository\User;

/**
 * UserRepository
 *
 * @package AppBundle\Repository\User
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * Retrieve user with specific username
     *
     * Research in Client and Partner resources
     *
     * @param array $criteria
     * @return array
     */
    public function findByInAllUsers(array $criteria)
    {

        // Search same username in Partners
        $statement = "
            SELECT p
            FROM AppBundle:User\Partner p
            WHERE p.username = :username
        ";

        // Execute the query and store results
        $user = $this->getEntityManager()
            ->createQuery($statement)
            ->setParameter('username', $criteria['username'])
            ->getArrayResult();

        if (count($user) == 0) {

            // If no match, search in Clients
            $statement = "
                SELECT c
                FROM AppBundle:User\Client c
                WHERE c.username = :username
            ";

            // Execute the query and store results
            $user = $this->getEntityManager()
                ->createQuery($statement)
                ->setParameter('username', $criteria['username'])
                ->getArrayResult();

        }

        // Return result
        return $user;

    }

}
