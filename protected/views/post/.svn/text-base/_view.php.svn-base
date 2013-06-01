<div class="post">
    
    
    <div id="update">  
  <div class="items"> 
    
      <ul>
          <li>   
          <div class="title">
		<?php echo CHtml::link(CHtml::encode($data->title), $data->url); ?>
	</div>
          </li>
      <li><span class="date">
		posted by <?php echo $data->author->username . ' on ' . date('F j, Y',$data->create_time); ?>
            </span><br />
                 <?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $data->content;
			$this->endWidget();
		?>
      </li>
      
      
      <div class="nav">
		<b>Tags:</b>
		<?php echo implode(', ', $data->tagLinks); ?>
		<br/>
		<?php echo CHtml::link('Permalink', $data->url); ?> |
		<?php echo CHtml::link("Comments ({$data->commentCount})",$data->url.'#comments'); ?> |
		Last updated on <?php echo date('F j, Y',$data->update_time); ?>
	</div>
        </ul>
       
    
    </div>

</div>
</div>
