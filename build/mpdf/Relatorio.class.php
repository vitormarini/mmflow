<?php
    date_default_timezone_set('America/Sao_Paulo');
    include_once($_SERVER['DOCUMENT_ROOT']."/mmflow/build/mpdf/mpdf.php");
    
    class relatorio extends mPDF {
        
        //Variáveis públicas da classe
        public $cabecalho;
        public $textoCabecalho;
        public $rodape;
        public $textoRodape       = false;
        public $corpo;
        public $formatoPagina     = "A4"; 
        public $orientacao        = "P";  
        public $nomeArquivo       = "relatorio.pdf";
        public $booAnulaCabecalho = false;
        public $booAnulaRodape    = false;
        public $paginacao         = false;
        
        //Variáveis privadas
        private $estilo;       
        
        /**
         * Instancia a Classe, definindo o cabeçalho e rodapé padrões
         */
        public function __construct(){
            //Define estilo padrão
            $this->estilo = file_get_contents($_SERVER['DOCUMENT_ROOT']."/mmflow/build/mpdf/relatorio.css");
        }
   
        /**
         * Gera o relatório em pdf.
         * Define as margens do documento, o formato da página, aplica o cabeçalho, corpo e rodapé do documento
         */
        public function geraRelatorio(){
            //Define o cabeçalho padrão
            if ( !$this->booAnulaCabecalho ) {
                $pagina = '';
                if ( $this->paginacao ){
                    $pagina = '<td class="text-center" width="07%"><b>Pag.: {PAGENO} </b></td>';
                }                                                   
                    $this->cabecalho = '
                        <table class="cabecalho" border=0>
                            <tr>                                
                                <td class="dados-relatorio text-center">' . $this->textoCabecalho . '</td>
                                '.$pagina.'
                            </tr>
                        </table>
                    ';
            }else{
                $this->cabecalho = $this->textoCabecalho;
            }
            
            //Define rodapé padrão
            if ( $this->rodape ) {
                
                if (  $this->textoRodape ){
                         $this->rodape = '
                        <table>
                            <tr class="">         
                                <td class="col-lg-3 text-center"   ><b>OSVALDO CRUZ - SP '. strtoupper(strftime('%d de %B de %Y', strtotime('today'))).'</b></td>
                        </table>
                    ';
                }else{
                    $this->rodape = '
                        <table>
                            <tr class="rodape">         
                                <td class="col-lg-3 text-left"   >{DATE d/m/Y H:i:s}</td>
                                <td class="col-lg-9 text-center">'. $_SESSION['codigo'] .' - '. $_SESSION['nome'] .'</td>
                                <td class="col-lg-3 text-right"  ><b>Página {PAGENO} </b></td>
                            </tr>
                        </table>
                    ';
                }
            }
            
            $pagina = ($this->orientacao == 'P') ? $this->formatoPagina : $this->formatoPagina . '-' .$this->orientacao;  
            parent::__construct('c', $pagina, '', '', 5, 5, 5, 5, 5, 0, $this->orientacao);
                      
            //Define espaçamento entre corpo e cabeçalho
            $this->setAutoTopMargin = "stretch";
            
            //Seta as partes do relatório                       
            parent::SetHTMLHeader( $this->cabecalho );
            parent::SetHTMLFooter( $this->rodape );
            parent::WriteHTML( $this->estilo, 1 );
            parent::WriteHTML( $this->corpo );
        }
        
        /**
         * Destrói a instancia da classe, exibindo o arquivo para o usuário
         */
        public function __destruct() {
            parent::Output( $this->nomeArquivo, "I" );
        }
        
    }