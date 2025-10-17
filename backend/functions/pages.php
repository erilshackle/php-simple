<?php


/**
 * Inicia o sistema de layout: carrega o header, inicia o buffer de saída
 * para capturar o conteúdo principal, e registra o footer para ser carregado
 * automaticamente ao final da execução do script.
 *
 * @param string $template_path O caminho absoluto para a pasta de templates (ex: '/caminho/do/projeto/templates').
 * @throws Exception Se a pasta de templates não existir ou não contiver os arquivos essenciais.
 */
function layout(string $header, ?string $footer = null): void
{

    // Função para carregar um template (header ou footer)
    $carregar_template = function (string $template_name): void {
        $template = rtrim(TEMPLATES, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $template_name . '.php';

        if (file_exists($template)) {
            require $template;
        } else {
            // Lançar um erro para templates essenciais que faltam
            throw new Exception("Template essencial não encontrado: '{$template_name}.php'");
        }
    };

    // Função de callback (shutdown) para finalizar o layout
    $finalizar_layout = function () use ($carregar_template, $footer): void {
        try {
            // 1. Obtém e exibe o conteúdo capturado (o corpo da página).
            // NOTA: O buffer de saída é iniciado APÓS o header ser enviado.
            echo ob_get_clean();
            
            // 2. Carrega o FOOTER (último elemento do layout).
            if($footer){
                $carregar_template( $footer);
            }
            
        } catch (Exception $e) {
            // Logar ou lidar com erros durante o shutdown (ex: footer faltando)
            error_log("Erro durante a finalização do layout: " . $e->getMessage());
        }
    };

    // --- Execução da Função Principal ---

    try {
        // 1. Carrega o HEAD e o HEADER da página (enviado imediatamente)
        $carregar_template($header);

        // 2. Inicia o buffer de saída. O conteúdo da sua aplicação será capturado a partir daqui.
        ob_start();

        // 3. Registra a função de callback para o shutdown.
        // O corpo da página será exibido e o footer será carregado quando o script terminar.
        register_shutdown_function($finalizar_layout);

    } catch (Exception $e) {
        // Lidar com falhas críticas (ex: Header faltando)
        die( $e->getMessage());
    }
}
