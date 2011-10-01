<?php

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', false);
sfContext::createInstance($configuration)->dispatch();


require dirname(__FILE__).'/lib/datasift.php';

require dirname(__FILE__).'/config.php';

$user = new DataSift_User(USERNAME, API_KEY);

$csdl = 'interaction.content any "charity,event,band"';

$definition = new DataSift_Definition($user, $csdl);

$hash = $definition->getHash();
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/datasift.js"></script>
<div class="twitterfeed" id="twitter"></div>
<input type="hidden" name="hash" id="hash" value="<?php echo $hash;?>" />
