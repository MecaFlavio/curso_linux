# Projeto Instalação LAMP

## Instalar o apache
	
	$ sudo apt-get install apache2

### Verificar versão do apache
	
	$ apache -apache2 -v

### Verificar arquivos do apache
	
	$ ls /etc/apache2/

### Alterando as Configurções do FireWall

	$ sudo ufw allow in "Apache Full"

### Verificar as aplicaçoes disponiveis o Firewall

	$ sudo ufw app list // apache full deve estar na lista

### Verificar se esta corretamente configurado

	Abrir navegador e acessae localhost na barra de endereços
	Também pode ser pelo ip local 127.0.0.1

## Instalando MySql

### Comando de instalação

 		$ sudo apt install mysql-server

### Configuração de acesso do banco

		$ sudo mysql_secure_installation

### Criando usúario no MySql

		#sudo mysql -u root

		### Cria usuário No banco:
			CREATE USER 'flavio'@'localhost' IDENTIFIED BY '1Mec@1379*';

		### Concede Privilegio para o usuário:
			GRANT ALL PRIVILEGES ON *.* TO 'flavio'@'localhost';

		### Verifica se o Usuário existe no banco:
			SELECT User FROM mysql.user;
				+------------------+
				| User             |
				+------------------+
				| debian-sys-maint |
				| flavio           |
				| mysql.infoschema |
				| mysql.session    |
				| mysql.sys        |
				| root             |
				+------------------+

### Criando Bando de Dados

		$ sudo mysql -u root // abre o mysql com o usuario root

	### Comando: show database; // mostra os bancos existentes no sistema
		mysql> SHOW DATABASES;
		+--------------------+
		| Database           |
		+--------------------+
		| information_schema |
		| mysql              |
		| performance_schema |
		| sys                |
		| test               |
		+--------------------+
		5 rows in set (0,01 sec)


	### Comando para criar tabela: CREATE DATABASE test; // Cria uma tabela de nome test

	### Comando para usar o database: USE test;  // Usa o db test

	### Comando para criar tabela no banco: CREATE TABLE users(id INT NOT NULL AUTO_INCREMENT, name VARCHAR(100), age INT, PRIMARY KEY(id));

	### Comando para ver tabelas: SHOW TABLES;
		mysql> show tables;
		+----------------+
		| Tables_in_test |
		+----------------+
		| users          |
		+----------------+
		1 row in set (0,00 sec)


	### Comando para inserir dados na tabela: INSERT INTO users (name, age) VALUES("Pedro", 25);

	### Comando para ver dados da tabela: SELECT * FROM users; // Mostra todos os dados da tabela users
		mysql> SELECT * FROM users;
		+----+-------+------+
		| id | name  | age  |
		+----+-------+------+
		|  1 | Pedro |   25 |
		+----+-------+------+
		1 row in set (0,00 sec)

	### comando: exit // Sai do mysql

## Istalando o PHP

### Comando para instalação do php e dependencias para tabalhar com o mysql

	$ sudo apt-get install php libapache2-mod-php php-mysql php-cli

### Comando para verificar versão do PHP

	$ php -v

### Altetar prioridade de leitura de arquivo php no apache

	$ sudo nano /etc/apache2/mods-enabled/dir.conf
	// O aquivo ira abrir e a espressão index.php deve ser posicionada antes de index.html

### Reiniciar o apache para carregar nova configuração

	$ sudo systemctl restart apache2

### Verificar se o apache esta rodando normalmente

	$ sudo systemctl status apache2

### Testando o processamento do PHP no apache

	Acessar:
		$ cd /var/www/html/
	Criar um aquivo:
		$ sudo nano info.php
	digirtar o codigo:
		<?php phpinfo(); ?>
	Abrir o navegado na barra de endereço digitar localhost/info.php
 
 ### Criando conexão do php com o banco e criando a query em um array

		 	<?php 
			
			$host = 'localhost';
			$user = 'flavio';
			$pass = '1Mec@1379*';
			$db = 'test';

			$conn = mysqli_connect($host, $user, $pass, $db);

			$sql = 'SELECT * FROM users';
			$result = mysqli_query($conn, $sql);

			$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

			//print_r($users);

			mysqli_close($conn);
		?>

### Criando a pagina hmtl para exibir os dados

			<?php 

				include_once "conn.php";

			?>

			<!DOCTYPE html>
			<html>
			<head>
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<title>Nosso app</title>
			</head>
			<body>
				<h1>Usuários do Sistema</h1>
				<ul>
					<?php foreach ($users as $user): ?>
						<li>Nome: 
							<?php echo $user['name']; ?>, 
							idade: 
							<?php echo $user['age'];?>		
						</li>
					<?php endforeach; ?>
				</ul>

			</body>
			</html>