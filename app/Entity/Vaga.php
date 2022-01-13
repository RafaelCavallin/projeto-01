<?php

namespace App\Entity;

use App\Db\Database;

class Vaga
{
    /**
     * Identificador único da vaga.
     * @var integer
     */
    public $id;

    /**
     * Título da vaga.
     * @var string
     */
    public $titulo;

    /**
     * Descrição da vaga (pode conter HTML).
     * @var string
     */
    public $descricao;

    /**
     * Define se a vaga está ativa.
     * @var integer(s/n)
     */
    public $ativo;

    /**
     * Data de publicação da vaga.
     * @var string
     */
    public $data;

    /**
     * Método responsável por cadastrar uma vaga.
     * @return boolean
     */
    public function cadastrar()
    {
        //Definir data
        $this->data = date('Y-m-d H:i:s');

        //Inserir a vaga no banco
        $obDatabase = new Database('vagas');
        $this->id = $obDatabase->insert([
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'ativo' => $this->ativo,
            'data' => $this->data,
        ]);

        //Retorna Sucesso
        return true;
    }

    /**
     * Método responsável por obter vagas do bd.
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */
    public static function getVagas($where = null, $order = null, $limit = null)
    {
        return (new Database('vagas'))->select($where, $order, $limit);
    }

}
