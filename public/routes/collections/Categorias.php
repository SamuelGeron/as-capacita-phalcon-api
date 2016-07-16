<?php
return call_user_func(
    function () {
        $categoriaCollection = new \Phalcon\Mvc\Micro\Collection();

        $categoriaCollection
            ->setPrefix('/v1/Categorias')
            ->setHandler('\App\Livros\Controllers\CategoriasController')
            ->setLazy(true);

        $categoriaCollection->get('/', 'getCategorias');
        $categoriaCollection->get('/{id:\d+}', 'getCategoria');

        $categoriaCollection->post('/', 'addCategoria');

        $categoriaCollection->put('/{id:\d+}', 'editCategoria');

        $categoriaCollection->delete('/{id:\d+}', 'deleteCategoria');

        return $categoriaCollection;
    }
);
