Маленький скрипт для работы с Яндекс Дзеном. Скрипт собирает статистику показов, чтений и дочитываний ваших публикаций, а также шлёт её в ваш телеграм бот. Также можно оценивать динамику роста показателей на графике.

Все необходимые настройки вы сможете проделать в файлах, которые лежат в папке config.

Файловая структура следующая:

<blockquote>    
<ul>
	<li>
		config
		<ul>
			<li>bot.php - настройки бота для Телеграм</li>	
			<li>config.php - настройки для выдачи прогноза дочитываний</li>
			<li>db.php - настройки подключения к БД</li>	
			<li>profiles.php - список аккаунтов в Дзене</li>	
		</ul>
	</li>
	<li>
		cookies
		<ul>
			<li>cookies.txt</li>				
		</ul>
	</li>
	<li>
		css
		<ul>
			<li>style.css</li>				
		</ul>
	</li>
	<li>
		js
		<ul>
			<li>index.js</li>				
		</ul>
	</li>
	<li>
		lib
		<ul>
			<li>
				commands
				<ul>
					<li>Getstats.php</li>
					<li>Runnable.php</li>
				</ul>
			</li>
			<li>
				entities
				<ul>
					<li>Channel.php</li>	
					<li>Command.php</li>
					<li>Period.php</li>	
					<li>Publication.php</li>	
					<li>Table.php</li>
				</ul>
			</li>	
			<li>Bot.php</li>	
			<li>CommandManager.php</li>
			<li>Config.php</li>	
			<li>DataGetter.php</li>
			<li>Logger.php</li>
			<li>MysqlDriver.php</li>
			<li>Reader.php</li>
			<li>Request.php</li>
			<li>simple_html_dom.php</li>
		</ul>
	</li>
	<li>bootstrap.php</li>
	<li>getdata.php</li>
	<li>getupdates.php</li>
	<li>import.php</li>
	<li>index.php</li>
	<li>zen_dump.sql</li>
</ul>
</blockquote>

Как пользоваться

1) Для запуска отправки отчётов в бот нужно повесить на крон скрипт import.php (например, на каждый час)
2) Для просмотра графика статистики нужно открыть проект в браузере http://[ИМЯ-ДОМЕНА]/index.php
3) Для запуска наблюдателя за очередью команд нужно повесить на крон скрипт getupdates.php (например, на каждую минуту)
