<?php

namespace PHP_MVC_Objet1\models\DAOs;

use PHP_MVC_Objet1\models\entities\Movie;


class MovieDao extends BaseDao {      // Cette classe hérite de BaseDao ce qui lui permet d'utiliser la connexion à la base de donnée qui est établie dans la classe BaseDao
    public function findById($id) : Movie {
        $stmt = $this->db->prepare("SELECT * FROM movie WHERE id = :id");
        $res = $stmt->execute([':id'=> $id]);

        if ($res) {
            return $this-> createObjectFromFields($stmt->fetch(\PDO::FETCH_ASSOC));
        } else {
            throw new \PDOException($stmt->errorInfo() [2]);
        }
    }

    public function createObjectFromFields($fields) : Movie {
        $movie= new Movie();
        $movie->setId($fields['id'])
                ->setTitle($fields['title'])
                ->setDescription($fields['description'])
                ->setDuration($fields['duration'])
                ->setDate(\Datetime::createFromFormat('Y-m-d',$fields['date']))
                ->setCoverImage($fields['cover_image']);
        return $movie;
    }
}