<h1><img src="./src/Disk/public/56x56.png">  Lochlite CMS</h1>
<p>Este não é um software de código aberto. A Lochlite concede a você uma licença pessoal limitada e revogável para gerenciar seu site. Consulte nossos termos de serviço, licença e privacidade para obter mais detalhes.</p>

<p>O Lochlite CMS é um moderno software de gerenciamento de conteúdo baseado na tecnologia PWA, com ele seu site conta com painel de controle administrativo, painel de usuário, sistema de login confiável e um moderno sistema de roteamento que permite a navegação sem recarregar a página. Esta é a sua melhor oportunidade de sair na frente da concorrência com um site robusto nos moldes das grandes empresas.</p>


<h3>Linguagem</h3>
<p>Anteriormente, o Lochlite CMS tinha uma licença mais restritiva, isso está mudando lentamente. Atualmente a Lochlite está disponibilizando os recursos sazonalmente, estando disponível neste primeiro momento apenas a versão em português do Brasil, mesmo assim, você pode começar a usá-lo.</p>
<span><img width="25" src="https://raw.githubusercontent.com/catamphetamine/country-flag-icons/master/3x2/BR.svg" /> Atual &nbsp;&nbsp;&nbsp;&nbsp; </span>
<span><img width="25" src="https://raw.githubusercontent.com/catamphetamine/country-flag-icons/master/3x2/US.svg" /> Próxima &nbsp;&nbsp;&nbsp;&nbsp;    </span>
<span><img width="25" src="https://raw.githubusercontent.com/catamphetamine/country-flag-icons/master/3x2/ES.svg" /> Setembro/2022 &nbsp;&nbsp;&nbsp;&nbsp; </span>
<span><img width="25" src="https://raw.githubusercontent.com/catamphetamine/country-flag-icons/master/3x2/JP.svg" /> Março/2023 &nbsp;&nbsp;&nbsp;&nbsp; </span>
<span><img width="25" src="https://raw.githubusercontent.com/catamphetamine/country-flag-icons/master/3x2/FR.svg" /> Maio/2023 &nbsp;&nbsp;&nbsp;&nbsp; </span>

<h3>Requisitos técnicos mínimos</h3>

```html
   Servidor web com os seguintes recursos:
   - PHP 8.1
   - MySQL 5.7 (recomendado 8.0) ou MariaDB 10.0
   - Armanezamento mínimo de 20 GB
   - Memoria RAM mínimo de 1.5 GB
   - Processador dual-core ou superior com suporte a tarefas em segundo plano
   - Serviço de e-mail (envio e recebimento)
   - Gerenciador de arquivos
```

<h3>Começando do zero com um kit inicial</h3>
<p>Atualmente você precisa de um desenvolvedor PHP para instalar este software ou ter conhecimento técnico moderado. Se você não tem certeza se pode instalá-lo ou se as coisas estão dando errado, envie um e-mail para <a href="mailto:drcg@lochlite.com"><strong>drcg@lochlite.com </strong></a> e nós iremos orientá-lo sobre o processo de instalação.</p>

<b>As instruções abaixo devem ser seguidas usando seu computador pessoal/corporativo e não diretamente no servidor. Na próxima seção você verá como colocar o Lochlite CMS no servidor web.</b>

   1. <h5>Instale o Composer no seu dispositivo</h5>
      <p>Siga as orientações <a href="https://getcomposer.org/doc/00-intro.md">deste página</a> e prossiga para a próxima etapa.</p>

   2. <h5>Baixe o Lochlite CMS</h5>
      <p>Abra o prompt de comando na pasta de sua escolha, cole o texto destacado abaixo e pressione Enter.</p>

      ```html
      composer create-project lochlite/cms-install lochlite 
      ```
      
      <p>Esse processo pode levar alguns minutos, não o interrompa, aguarde até que o prompt de comando seja desbloqueado para novos comandos.</p>
      
   3. <h5>Configure o banco de dados</h5>
      <p>Na etapa anterior uma pasta chamada 'lochlite' foi criada pelo sistema. Entre na pasta 'lochlite' e localize um arquivo chamado 'env' ou '.env'.</p>
      <p>Assim que encontrar o arquivo 'env', abra-o em um editor de texto, edite o trecho abaixo com os detalhes correspondentes ao seu banco de dados e salve as alterações.</p>
      
      ```html
       DB_CONNECTION=mysql
       DB_HOST=127.0.0.1
       DB_PORT=3306
       DB_DATABASE=database_name
       DB_USERNAME=database_username
       DB_PASSWORD=database_password 
      ```
      <p>Se você não tiver um banco de dados ou não souber quais são os detalhes do banco de dados, entre em contato com sua empresa de hospedagem ou departamento de TI para obter mais detalhes.</p>
   
   4. <h5>Fazendo os ajustes finais</h5>
      <p>Retorne ao prompt de comando aberto na etapa 1, cole o texto destacado abaixo e pressione Enter.</p>
 
      ```html
      cd lochlite; php artisan migrate --force && php artisan db:seed --force 
      ```
      <p>Esse processo pode levar alguns minutos, não o interrompa, aguarde até que o prompt de comando seja desbloqueado para novos comandos.</p>
      
<p>Se nenhum erro ocorreu nas etapas anteriores, você está pronto para colocar seu site online e começar a criar suas páginas e artigos.</p>    

<h3>Colocando em um servidor web</h3>
<p>Os passos descritos na seção anterior <strong>devem ser feitos em seu computador local e não diretamente no servidor</strong>, para colocar o Lochlite CMS em um servidor web com segurança, alguns passos adicionais são necessários.</p>    

         
