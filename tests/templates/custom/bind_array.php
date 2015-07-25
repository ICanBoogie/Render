<?php

/* @var $this ArrayObject */

echo get_class($this) . ':[' . implode(', ', $this->getArrayCopy()) . ']';
