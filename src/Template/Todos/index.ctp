
<h2>Todo - Liste de tâches - CakePHP 3.0</h2>
			
		<!--  Formulaire d'ajout -->
		<br />
		<?php echo $this->Form->create(); ?>
			<div class="form-group">
				<div class="controls">
			        <div class="input-group">
			            <input type="text" class="form-control" name="text" id="input_add" placeholder="AJOUTER UNE TÂCHE" />
			            <span class="input-group-btn">
			            	<button type="button" class="btn btn-primary btn-border-radius-right" onclick="ajax_add('todos/ajax_add',text.value,'#input_add')">
			            	AJOUTER
			            	</button>
			            </span>
			            <small class="text-danger"></small>
			        </div>
			    </div>
			</div>
		<?php echo $this->Form->end(); ?>
	
		<!--  Todos -->
		<?php if (isset($todos)): ?>
		    <?php include_once('_todos.ctp'); ?>
		<?php endif; ?>
		