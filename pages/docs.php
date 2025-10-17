<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentação - PHP Simple</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            padding-top: 30px;
            padding-bottom: 50px;
        }

        .code-block {
            background-color: #272822;
            /* Fundo escuro para código */
            color: #f8f8f2;
            padding: 15px;
            border-radius: 6px;
            overflow-x: auto;
            margin-bottom: 20px;
            font-family: 'Consolas', 'Monaco', 'Andale Mono', monospace;
            font-size: 0.9em;
        }

        pre {
            margin: 0;
            white-space: pre-wrap;
            /* Quebra de linha para código grande */
        }

        h2,
        h3,
        h4 {
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 5px;
            margin-top: 30px;
            margin-bottom: 15px;
        }

        .table-docs th,
        .table-docs td {
            vertical-align: middle;
        }

        .toc a {
            display: block;
            padding: 5px 0;
            color: #007bff;
        }

        .toc {
            border-left: 3px solid #007bff;
            padding-left: 15px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-code-slash" viewBox="0 0 16 16">
                    <path d="M10.478 1.647a.5.5 0 0 0-.555-.125L7.29 2.766 4.975 1.768a.5.5 0 0 0-.5-.145c-.256.091-.3.308-.09.525l2.64 4.09-2.64 4.09a.5.5 0 0 0 .584.77l2.185-1.048 2.637 4.09a.5.5 0 0 0 .808-.524l-2.64-4.09 2.64-4.09a.5.5 0 0 0-.012-.416" />
                </svg>
                PHP Simple - Documentação
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="row">

            <div class="col-lg-3 d-none d-lg-block">
                <div class="sticky-top" style="top: 20px;">
                    <h4>Conteúdo</h4>
                    <nav id="toc" class="toc">
                        <a href="#visao-geral">1. Visão Geral</a>
                        <a href="#estrutura">2. Estrutura de Diretórios</a>
                        <a href="#fluxo">3. Fluxo de Execução</a>
                        <a href="#roteamento">4. Roteamento</a>
                        <a href="#configuracoes">5. Configurações</a>
                        <a href="#helpers">6. Funções Auxiliares (Helpers)</a>
                        <a href="#autoloader">7. Autoloader de Classes</a>
                    </nav>
                </div>
            </div>

            <div class="col-lg-9">

                <h1 class="mb-4 text-primary">Documentação do Projeto "PHP Simple"</h1>

                <section id="visao-geral">
                    <h2>1. Visão Geral</h2>
                    <p class="lead">O <b>PHP Simple</b> é um micro-framework ou "boilerplate" simples e leve baseado em PHP puro. Ele implementa um sistema básico de roteamento "Front Controller", autoloader de classes e helpers essenciais para manipulação de *templates* e banco de dados.</p>
                    <p>O objetivo principal é oferecer uma estrutura de projeto organizada com baixo *overhead* para que o desenvolvedor possa focar rapidamente na lógica de negócio.</p>
                </section>

                <section id="estrutura">
                    <h2>2. Estrutura de Diretórios</h2>
                    <p>O projeto segue uma estrutura de diretórios limpa e intuitiva:</p>
                    <div class="code-block">
                        <pre>
/
|-- assets/           # Arquivos estáticos (CSS, JS, Imagens, Fontes)
|-- backend/          # Núcleo e lógica do sistema
|   |-- configs/      # Arquivos de configuração (DB, etc.)
|   |-- classes/      # Classes OOP (autoloader ativo)
|   |-- functions/    # Funções auxiliares (helpers)
|   |-- init.php      # Arquivo de inicialização do sistema
|-- pages/            # Arquivos PHP que representam as páginas (procedural)
|-- templates/        # Componentes de layout (header, footer, snippets)
|-- .htaccess         # Configuração do reescrita de URL
|-- main.php          # O "Front Controller" do projeto
                        </pre>
                    </div>
                </section>

                <section id="fluxo">
                    <h2>3. Fluxo de Execução</h2>
                    <p>O fluxo de execução é centralizado no <b><i>main.php</i></b> e no roteador.</p>

                    <h3 id="fluxo-htaccess">3.1. Arquivo<i>.htaccess</i>(Configuração)</h3>
                    <p>Todas as requisições, exceto arquivos em<i>/assets/</i>ou arquivos/diretórios existentes, são redirecionadas para <i>main.php</i>. Isso é fundamental para o roteamento do tipo "Front Controller".</p>
                    <div class="code-block">
                        <pre>&lt;IfModule mod_rewrite.c&gt;
  RewriteEngine On
  RewriteBase /php_simple/
  
  RewriteCond %{REQUEST_URI} !^/assets/.*$
  RewriteCond %{REQUEST_FILENAME} !-f
  
  # Reescreve para main.php
  RewriteRule ^(.*)$ main.php [L,QSA]
&lt;/IfModule&gt;</pre>
                    </div>

                    <h3 id="fluxo-main">3.2. Arquivo<i>main.php</i>(Ponto de Entrada)</h3>
                    <p>O<i>main.php</i> é o primeiro script PHP a ser executado.</p>
                    <div class="code-block">
                        <pre>&lt;?php

require_once __DIR__ . '/backend/init.php';

$baseUrl = "http://localhost/php_simple/";

// Chamar a função para rotear a requisição
routeToPage('php_simple');</pre>
                    </div>
                </section>

                <section id="roteamento">
                    <h2>4. Roteamento (Mapeamento de URL)</h2>
                    <p>A função<i>routeToPage($site)</i>no<i>init.php</i>é a responsável por traduzir a URL para o caminho do arquivo correspondente na pasta <b><i>pages/</i></b>.</p>

                    <table class="table table-striped table-bordered table-docs">
                        <thead class="table-dark">
                            <tr>
                                <th>URL Solicitada</th>
                                <th>Caminho do Arquivo em <i>pages/</i></th>
                                <th>Notas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>/php_simple/</code></td>
                                <td><code>pages/index.php</code></td>
                                <td>Raiz do site.</td>
                            </tr>
                            <tr>
                                <td><code>/php_simple/sobre</code></td>
                                <td><code>pages/sobre.php</code></td>
                                <td>Arquivo direto.</td>
                            </tr>
                            <tr>
                                <td><code>/php_simple/contato/</code></td>
                                <td><code>pages/contato/index.php</code></td>
                                <td>Subdiretório com <i>index.php</i>.</td>
                            </tr>
                            <tr>
                                <td>Qualquer outra</td>
                                <td><code>pages/404.php</code> ou Erro 404</td>
                                <td>Se nenhum arquivo/diretório for encontrado.</td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                <section id="configuracoes">
                    <h2>5. Configurações</h2>
                    <p>As configurações globais do sistema estão localizadas em <i>backend/configs/</i>.</p>

                    <h3 id="config-db">5.1. <i>backend/configs/database.php</i></h3>
                    <p>Contém as constantes de acesso ao banco de dados PDO.</p>
                    <div class="code-block">
                        <pre>&lt;?php

// Configurações do banco de dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'seu_banco');
define('DB_USER', 'seu_usuario');
define('DB_PASS', 'sua_senha');
define('DB_CHARSET', 'utf8mb4');</pre>
                    </div>
                    <div class="alert alert-warning">
                        <strong>Atenção:</strong> Altere os valores acima para os dados do seu ambiente.
                    </div>
                </section>

                <section id="helpers">
                    <h2>6. Funções Auxiliares (Helpers)</h2>
                    <p>O projeto fornece diversas funções auxiliares para agilizar o desenvolvimento, localizadas em <i>backend/functions/</i>.</p>

                    <h3 id="helpers-gerais">6.1. Helpers Gerais (<i>functions.php</i>)</h3>
                    <table class="table table-sm table-bordered">
                        <thead class="table-info">
                            <tr>
                                <th>Função</th>
                                <th>Descrição</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>debug($var)</code></td>
                                <td>Imprime o conteúdo de uma variável formatado (<code>&lt;pre&gt;</code>) e <b>finaliza a execução</b> (<code>exit</code>).</td>
                            </tr>
                            <tr>
                                <td><code>template(string $filename, $data = [])</code></td>
                                <td>Retorna o caminho de um arquivo de template (em <code>templates/</code>) e extrai o array <code>$data</code> para variáveis locais.</td>
                            </tr>
                            <tr>
                                <td><code>asset($file)</code></td>
                                <td>Retorna o caminho completo de um arquivo dentro da pasta <code>assets/</code>, respeitando a <code>$baseUrl</code>.</td>
                            </tr>
                        </tbody>
                    </table>

                    <h3 id="helpers-layout">6.2. Helpers de Layout (<i>pages.php</i>)</h3>
                    <p>A função<i>layout()</i>é a chave para estruturar suas páginas, encapsulando o conteúdo entre o cabeçalho e o rodapé.</p>
                    <div class="code-block">
                        <pre>layout(string $header, ?string $footer = null): void</pre>
                    </div>
                    <p><strong>Uso:</strong> No topo de um arquivo em <i>pages/</i>. Exemplo: <i>layout('header_principal', 'footer_simples');</i></p>
                    <p><strong>Mecanismo:</strong> Utiliza o<i>register_shutdown_function</i>e o *Output Buffering* para carregar o footer após todo o conteúdo da página.</p>

                    <h3 id="helpers-db">6.3. Helpers de Banco de Dados (<i>database.php</i>)</h3>
                    <p>Baseados em PDO e *prepared statements* para segurança e performance.</p>
                    <table class="table table-sm table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th>Função</th>
                                <th>Descrição</th>
                                <th>Retorno</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>db_connection()</code></td>
                                <td>Obtém a instância da conexão PDO (Singleton).</td>
                                <td>Objeto <code>PDO</code>.</td>
                            </tr>
                            <tr>
                                <td><code>db_execute($sql, $params = [])</code></td>
                                <td>Executa <code>INSERT</code>, <code>UPDATE</code> ou <code>DELETE</code>.</td>
                                <td>Número de linhas afetadas.</td>
                            </tr>
                            <tr>
                                <td><code>db_fetch($sql, $params = [])</code></td>
                                <td>Executa <code>SELECT</code> e retorna <b>uma única linha</b> (fetch).</td>
                                <td><code>array</code> associativo ou <code>false</code>.</td>
                            </tr>
                            <tr>
                                <td><code>db_fetch_all($sql, $params = [])</code></td>
                                <td>Executa <code>SELECT</code> e retorna <b>todas as linhas</b> (fetchAll).</td>
                                <td><code>array</code> de arrays associativos.</td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                <section id="autoloader">
                    <h2>7. Autoloader de Classes</h2>
                    <p>O<i>init.php</i>configura um autoloader para carregar classes automaticamente da pasta <b><i>backend/classes/</i></b>.</p>
                    <p>O autoloader suporta *namespaces* mapeando o namespace para a estrutura de diretórios.</p>

                    <p><strong>Exemplo:</strong></p>
                    <table class="table table-sm table-bordered w-75">
                        <thead class="table-secondary">
                            <tr>
                                <th>Classe Solicitada</th>
                                <th>Caminho do Arquivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>User</code></td>
                                <td><code>backend/classes/User.php</code></td>
                            </tr>
                        </tbody>
                    </table>

                    <p><strong>Estrutura da Classe:</strong></p>
                    <div class="code-block">
                        <pre>&lt;?php

class User {
    // ... lógica da classe
}</pre>
                    </div>

                    <p><strong>Uso:</strong></p>
                    <div class="code-block">
                        <pre>$db = User();</pre>
                    </div>
                </section>

                <hr class="my-5">
                <p class="text-center text-muted">Fim da Documentação - PHP Simple Project.</p>
                <p class="text-center text-muted small">
                    <a href="https://github.com/erilshackle" target="_blank" class="text-link text-decoration-none">
                        By @erilshackle - Eril TS Carvalho
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>