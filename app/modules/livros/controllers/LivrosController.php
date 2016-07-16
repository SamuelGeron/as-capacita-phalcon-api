<?php
namespace App\Livros\Controllers;

use App\Controllers\RESTController;
use App\Livros\Models\Livros;

class LivrosController extends RESTController
{
   
    public function getLivros()
    {
        try {
            $query = new \Phalcon\Mvc\Model\Query\Builder();
            $query->addFrom('\App\Livros\Models\Livros', 'Livros')
                ->columns(
                    [
                        'Livros.iLivroId',
                        'Livros.sTitulo',
                        'Livros.sAutor',
                        'Livros.iCategoriaId',
                        'Categorias.iCategoriaId',
                        'Categorias.sDescricaoCategoria',
                    ]
                )
                ->leftJoin('\App\Livros\Models\Categorias', 'Livros.iCategoriaId = Categorias.iCategoriaId', 'Categorias')
                ->where('true');

            return $query
                ->getQuery()
                ->execute();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function getLivro($iLivroId)
    {
        try {
            $livros = (new Livros())->findFirst(
                [
                    'conditions' => "iLivroId = '$iLivroId'",
                    'columns' => $this->partialFields,
                ]
            );

            return $livros;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function addLivro()
    {
        try {
            $livrosModel = new Livros();
            $livrosModel->sTitulo = $this->di->get('request')->getPost('sTitulo');
            $livrosModel->sAutor = $this->di->get('request')->getPost('sAutor');
            $livrosModel->iCategoriaId = $this->di->get('request')->getPost('iCategoriaId');

            $livrosModel->saveDB();

            return $livrosModel;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function editLivro($iLivroId)
    {
        try {
            $put = $this->di->get('request')->getPut();

            $livro = (new Livros())->findFirst($iLivroId);

            if (false === $livro) {
                throw new \Exception("This record doesn't exist", 200);
            }

            $livro->sTitulo = isset($put['sTitulo']) ? $put['sTitulo'] : $livro->sTitulo;
            $livro->sAutor = isset($put['sAutor']) ? $put['sAutor'] : $livro->sAutor;
            $livro->iCategoriaId = isset($put['iCategoriaId']) ? $put['iCategoriaId'] : $livro->iCategoriaId;

            $livro->saveDB();

            return $livro;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function deleteLivro($iLivroId)
    {
        try {
            $livro = (new Livros())->findFirst($iLivroId);

            if (false === $livro) {
                throw new \Exception("This record doesn't exist", 200);
            }

            return ['success' => $livro->delete()];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
