 ---------------------
| Directory Structure |
 ---------------------

Options
|
|___\.git (metadata used by Git)
|
|___\.settings (metadata used by the Aptana IDE)
|
|___\analytics
|	|
|	|___blackscholes.php (implements black scholes pricer)
|	|___deltahedging.php (implements delta hedging simulation)
| 	|___euroption.php (implements euro option class)
|	|___utilities.php (collection of miscellanous helper function)
|
|___\config
|	|
|	|___css.php (CDN links to hosted CSS and cotains css for popup boxes)
|	|___database.php (database connection)
|	|___js.php (CDN links to hosted JS)
|
|___templates
|	|
|	|___etfdropdown.php (html for selector element used in both iv.php and dh.php)
|	|___expirydatepicker.php (html for datepicker element used in both iv.php and dh.hp)
|
|___config
|	|
|	|___deltahedginghandler.php (prepares data for calculation then prepares output for display)
|	|___dh.php (content and UI for delta hedging page)
|	|___impliedvolatilityhander.php (prepares data for calculation then prepares output for display)
|	|___index.php (main page)
|	|___iv.php (content and UI for implied volatility page)


 ---------------------
| Viewing the website |
 ---------------------
The website is best viewed with Chrome.  Firefox, Safari and IE were also tested but there are HTML5 elements which may cause issues with these browsers

 ----------------
| User Interface |
 ----------------
The website uses Twitter Bootstrapp CSS, jQuery CSS, and HTML5 for the UI.

 ------------------
| User Interaction |
 ------------------
jQuery / AJAX and Javasript are used to drive user interaction and dynamic updating without page reloading

 -----
| PHP |
 -----
PHP is the workhorse for the website.  While the UI is not PHP, all content is generated using PHP.  All calcualtions are done on the server using PHP
