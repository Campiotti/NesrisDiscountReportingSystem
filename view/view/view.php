<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 03.05.2018
 * Time: 08:50
 */
$report = $this->report;
?>
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size:125%;
    }
    table tr:nth-child(even) {
        background-color: #eee;
    }
    table tr:nth-child(odd) {
        background-color: #fff;
    }
    table th {
        color: white;
        background-color: black;
    }
    .tmpLarge{
        font-size:150%;

    }
</style>
<div class="content">
  <div class="container_12">
    <div class="grid_12">
      <h3 class="pb1"><span><?php echo$report->title?></span></h3>
        <div class="grid_8">
            <div class="tmpLarge"><span>Expenses</span></div>
            <br>
        <table>
            <tr>
                <th>Unit Type</th>
                <th>Unit</th>
                <th>Unit Price</th>
                <th>Cost</th>
            </tr>
            <?php foreach ($this->expenses as $expense){ ?>
            <tr>
                <td><?php echo$expense['unitType']?></td>
                <td><?php echo$expense['unit']?></td>
                <td><?php echo$expense['unitPrice']?></td>
                <td><?php echo$this->htmlHelper->formatPrice($expense['cost'],0)?></td>
            </tr>
            <?php } ?>
        </table>
        </div>
    </div>
  </div>
</div>