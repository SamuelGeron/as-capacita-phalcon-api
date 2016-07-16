<?php
namespace App\Livros\Controllers;

use App\Controllers\RESTController;
use App\Livros\Models\Categorias;

class CategoriasController extends RESTController
{

    public function getCategorias()
    {
        try {
            $categorias = (new Categorias())->find(
                [
                    'conditions' => 'true ' . $this->getConditions(),
                    'columns' => $this->partialFields,
                    'limit' => $this->limit
                ]
            );

            return $categorias;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }


    public function getCategoria($iCategoriaId)
    {
        try {
            $categorias = (new Categorias())->findFirst(
                [
                    'conditions' => "iCategoriaId = '$iCategoriaId'",
                    'columns' => $this->partialFields,
                ]
            );

            return $categorias;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }


    public function addCategoria()
    {
        try {
            $categoria = new Categorias();
            $categoria->sDescricaoCategoria = $this->di->get('request')->getPost('sDescricaoCategoria');

            $categoria->saveDB();

            return $categoria;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }


    public function editCategoria($iCategoriaId)
    {
        try {
            $put = $this->di->get('request')->getPut();

            $categoria = (new Categorias())->findFirst($iCategoriaId);

            if (false === $categoria) {
                throw new \Exception("This record doesn't exist", 200);
            }

            $categoria->iCategoriaId = isset($put['iCategoriaId']) ? $put['iCategoriaId'] : $categoria->iCategoriaId;
            $categoria->sDescricaoCategoria = isset($put['sDescricaoCategoria']) ? $put['sDescricaoCategoria'] : $sDescricaoCategoria->sDescricaoCategoria;

            $categoria->saveDB();

            return $categoria;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

   
    public function deleteCategoria($iCategoriaId)
    {
        try {
            $categoria = (new Categorias())->findFirst($iCategoriaId);

            if (false === $categoria) {
                throw new \Exception("This record doesn't exist", 200);
            }

            return ['success' => $categoria->delete()];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
