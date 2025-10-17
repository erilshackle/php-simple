<?php

/**
 * FUNçOES QUE AGILIZAM A UTILIZACAO DA BASE DE DADOS (HELPERS)
 * 
 * db_connection -> para obter o $pdo ou $conn (como preferir)
 * db_execute()  -> para executar uma query do tipo INSER/DELETE/UPDATE
 * db_fetch()    -> para executar uma query do tipo SELECT que fazer o fetch
 * db_fetch_all()    -> para executar uma query do tipo SELECT que fazer o fetchAll()
 * 
 * PARA CONFIGURAR A DB vÁ EM:
 * @see backend/configs/databse.php
 */
$conn = null;

/**
 * Conecta-se ao banco de dados usando PDO e o padrão Singleton.
 *
 * @return PDO A instância da conexão com o banco de dados.
 */
function db_connection() {
    static $pdo = null;

    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }
    return $pdo;
}

/**
 * Executa uma instrução SQL (INSERT, UPDATE, DELETE).
 *
 * @param string $sql A instrução SQL com placeholders.
 * @param array $params Os parâmetros para o prepared statement.
 * @return int O número de linhas afetadas.
 */
function db_execute($sql, $params = []) {
    $pdo = db_connection();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->rowCount();
}

/**
 * Executa uma instrução SQL e retorna uma única linha.
 *
 * @param string $sql A instrução SQL (SELECT) com placeholders.
 * @param array $params Os parâmetros para o prepared statement.
 * @return array|false Uma linha do resultado como um array associativo, ou false se não houver resultado.
 */
function db_fetch($sql, $params = []) {
    $pdo = db_connection();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetch();
}

/**
 * Executa uma instrução SQL e retorna todas as linhas.
 *
 * @param string $sql A instrução SQL (SELECT) com placeholders.
 * @param array $params Os parâmetros para o prepared statement.
 * @return array Um array de todos os resultados.
 */
function db_fetch_all($sql, $params = []) {
    $pdo = db_connection();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}
