<div id="app" class="container">

    <navigation-bar v-bind:authenticated="parseInt(<?php echo $authorized ? 1 : 0; ?>)"></navigation-bar>
    <tasks-list v-bind:edit-available="parseInt(<?php echo $authorized ? 1 : 0; ?>)"></tasks-list>
</div>