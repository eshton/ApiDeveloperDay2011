<?php

require dirname(__FILE__).'/lib/datasift.php';

require dirname(__FILE__).'/config.php';

$user = new DataSift_User(USERNAME, API_KEY);

$csdl = 'interaction.content any "charity,event,donate"';

$definition = new DataSift_Definition($user, $csdl);

$hash = $definition->getHash();

return $hash;
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/datasift.js"></script>
<div class="twitterfeed" id="twitter"></div>
<input type="hidden" name="hash" id="hash" value="<?php echo $hash;?>" />
