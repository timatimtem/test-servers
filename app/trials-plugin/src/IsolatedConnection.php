<?php
/**
 * Created by PhpStorm.
 * User: illia
 * Date: 16.08.18
 * Time: 14:51
 */

use /** @noinspection PhpUndefinedClassInspection */
    /** @noinspection PhpUndefinedNamespaceInspection */
    Illuminate\Database\Capsule\Manager;

use
    /** @noinspection PhpUndefinedNamespaceInspection */
    /** @noinspection PhpUndefinedClassInspection */
    Illuminate\Database\Connection;

use
    /** @noinspection PhpUndefinedNamespaceInspection */
    /** @noinspection PhpUndefinedClassInspection */
    Illuminate\Database\Query\Grammars\MySqlGrammar;

class IsolatedConnection extends Connection
{
    public function __construct() {
        $conn = Manager::connection();

        parent::__construct($conn->getPdo(), $conn->getDatabaseName(), $conn->getTablePrefix(), $conn->config);

        $this->setQueryGrammar(new MySqlGrammar());
    }
}