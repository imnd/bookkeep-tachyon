<?php
include('..\\vendor\\tachyon\\autoload.php');

\tachyon\dic\Container::getInstanceOf('Router')->dispatch();
