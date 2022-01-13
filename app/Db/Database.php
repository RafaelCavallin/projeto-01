<?php

namespace App\DB;

use PDOException;
use \PDO;

class Database
{
    /**
     * Host de conexão com o banco de dados;
     * @var string
     */
    const HOST = 'localhost';

    /**
     * Nome do banco de dados;
     * @var string
     */
    const NAME = 'vagas';

    /**
     * Usuário do banco de dados;
     * @var string
     */
    const USER = 'root';

    /**
     * Senha (password) de acesso do banco de dados;
     * @var string
     */
    const PASS = '';

    /**
     * Nome da table a ser manipulada;
     * @var string
     */
    private $table;

    /**
     * Instãncia de conexão com o banco de dados;
     * @var PDO
     */
    private $connection;

    /**
     * Define a tabela e instancia a conexão;
     * @var string $table
     */
    public function __construct($table = null)
    {
        $this->table = $table;
        $this->setConnection();
    }

    /**
     * Método responsável por criar uma conexão com o banco de dados.
     */
    private function setConnection()
    {
        try {
            $this->connection = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::NAME, self::USER, self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }

    /**
     * Método responsável por executar queries dentro do DB.
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    public function execute($query, $params = [])
    {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }

    /**
     * Método responsável por inserir dados no banco.
     * @param array $values [field => values]
     * @return integer ID inserido
     */
    public function insert($values)
    {
        // Dados da query
        $fields = array_keys($values);
        $binds = array_pad([], count($fields), '?');

        //Monta a query
        $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') values (' . implode(',', $binds) . ')';

        // Executa o Insert
        $this->execute($query, array_values($values));

        //Retorna o ID inserido.
        return $this->connection->lastInsertId();
    }

    /**
     * Método responsável por executar uma consulta no banco.
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return PDOStatement
     */
    public function select($where = null, $order = null, $limit = null)
    {
        $query = 'SELECT * FROM';
    }
}

/* parei em 01:03:07
https://www.youtube.com/watch?v=uG64BgrlX7o&list=PLI8rtxINV2txAFC0lsAkk_u8m2322BGf3&index=1&t=1s
 */
