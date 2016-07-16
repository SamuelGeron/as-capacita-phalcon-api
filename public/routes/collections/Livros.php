<?php
return call_user_func(
    function () {
        $livroCollection = new \Phalcon\Mvc\Micro\Collection();

        $livroCollection
            ->setPrefix('/v1/Livros')
            ->setHandler('\App\Livros\Controllers\LivrosController')
            ->setLazy(true);

        $livroCollection->get('/', 'getLivros');
        $livroCollection->get('/{id:\d+}', 'getLivro');

        $livroCollection->post('/', 'addLivro');

        $livroCollection->put('/{id:\d+}', 'editLivro');

        $livroCollection->delete('/{id:\d+}', 'deleteLivro');

        return $livroCollection;
    }
);
