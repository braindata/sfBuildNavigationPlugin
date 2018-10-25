<?php $count = 0; ?>
<ul class="nav" id="<?php echo $style ?>">
  <?php $items = $navigation->getItems(ESC_RAW);?>
  <?php foreach($items as $name => $item): ?>
     <?php //var_dump($item); ?>

    <?php $count++;?>
    <li <?php if($item['is_active']) echo "class='active'" ?>><?php echo link_to(__($name, null, "navigation"), $item['url'], $item['param']) ?></li>
    <?php if (isset($separator) && $count < count($navigation->getItems())): ?><li><?php echo $sf_data->getRaw('separator') ?></li><?php endif ?>
  <?php endforeach ?>
</ul>