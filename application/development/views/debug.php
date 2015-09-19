<?php if(isset($this->var['testdata'])): ?>
    <?php if(is_array($this->var['testdata'])) :?>
    <pre><?php print_r($this->var['testdata']);?></pre>
    <?php else: echo $this->var['testdata'];?>
    <?php endif; ?>
<?php endif; ?>
