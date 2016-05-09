<html>
<head>
   <link href="style.css" rel="stylesheet">
</head>
<body>
<h1>Champion Mastery TOP</h1>

<form action='' method='POST' align='center'>
<p>Choose region:
<select name='server'>
<option value='euw'>Europe West</option>
<option value='ru'>Russia</option>
<option value='eune'>EU Nordic & East</option>
<option value='kr'>Korea</option>
<option value='lan'>Latin America North</option>
<option value='las'>Latin America South</option>
<option value='na'>North America</option>
<option value='oce'>Oceania</option>
<option value='tr'>Turkey</option>
<option value='br'>Brazil</option>
<option value='jp'>Japan</option>
</select>
Enter summoner name:
<input name='summonername' type='text'>
<input type="submit" value="Submit" />
</p>
</form>

<?php
include 'key.php';
$regions = array(
	"br" => "BR1",
	"eune" => "EUN1",
	"euw" => "EUW1",
	"jp" => "JP1",
	"kr" => "KR",
	"lan" => "LA1",
	"las" => "LA2",
	"na" => "NA1",
	"oce" => "OC1",
	"ru" => "RU",
	"tr" => "TR1"
);
$champions_data = json_decode(file_get_contents("https://global.api.pvp.net/api/lol/static-data/euw/v1.2/champion?api_key=$api_key"), TRUE);
$champions = array();
foreach ($champions_data[data] as $data){
	$id = $data[id];
	$name = $data[name];
	$key = $data["key"];
	$champions[$id]["name"] = $name;
	$champions[$id]["key"] = $key;
}
$server = $_POST[server];
$region = $regions[$server];
$summoner_name = $_POST[summonername];

if (isset($summoner_name)){

$summoner_data = json_decode(file_get_contents("https://$server.api.pvp.net/api/lol/$server/v1.4/summoner/by-name/$summoner_name?api_key=$api_key"), TRUE);
$summoner = $summoner_data[mb_strtolower($summoner_name)];
$summoner_id = $summoner[id];

$mastery_data = json_decode(file_get_contents("https://$server.api.pvp.net/championmastery/location/$region/player/$summoner_id/champions?api_key=$api_key"), TRUE);
echo "<table align=center>";
foreach ($mastery_data as $value){
	echo "<tr align=center>";
	$championId=$value[championId];
	$championLevel = $value[championLevel];
	$championPoints = $value[championPoints];
	$champion_name = $champions[$championId]["name"];
	$key=$champions[$championId]["key"];
	echo "<td width=100px><img src='http://ddragon.leagueoflegends.com/cdn/6.9.1/img/champion/$key.png' width='120' height='120'></td>";
	echo "<td class='level'>$championLevel</td>";
	echo "<td>$championPoints</td>";
	echo "</tr>";
}
echo "</table>";
}


?>
</body>
</html>