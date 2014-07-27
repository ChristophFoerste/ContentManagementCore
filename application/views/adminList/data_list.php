<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php
if(count($adminListArray) > 0){
    $headRow = $adminListArray[0];
?>
    <div class="table-responsive">
        <table class="table table-striped table-condensed" style="width: 100%;" id="adminListTable">
            <thead>
            <tr>
                <?php
                foreach($headRow as $key=>$value){
                    echo '<th>'.$this->lang->line("adminList_tableTranslator_".$key).'</th>';
                }
                ?>
            </tr>
            </thead>
            </tbody>
                <?php
                foreach($adminListArray as $item){
                    echo '<tr class="adminSelectRow" data-adminID="'.$item->ID.'">';
                    foreach($item as $key=>$value){
                        if($value instanceof DateTime){
                            echo "<td>".$highlighter->highlightString($value->format("d.m.Y H:i:s"), $adminSearchString)."</td>";
                        } else {
                            echo "<td>".$highlighter->highlightString($value, $adminSearchString)."</td>";
                        }
                    }
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
<?php
} else {
?>
    <p class="text-danger text-center"><?php echo $this->lang->line("adminList_error_noListElements");?></p>
<?php
}
?>