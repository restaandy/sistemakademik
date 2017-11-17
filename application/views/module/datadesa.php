<?php  
include("libraries/autoload.php" );
use GroceryCrud\ Core\ GroceryCrud;
use GroceryCrud\ Core\ Model\ whereModel;
$database = include( 'database.php' ); //config database Grocery
		$config = include( 'config.php' ); //config library Grocery
		$this->crud = new GroceryCrud( $config, $database ); //initialize Grocery
		/* start Grocery global configuration */
		$this->crud->unsetDeleteMultiple();
		$this->crud->unsetDeleteMultiple();
		$this->crud->unsetPrint();
		$this->crud->unsetExport();
		$this->crud->unsetJquery();		
		$this->crud->setTable('data_desa');
      	$output = $this->crud->render();

      if ($output->isJSONResponse) {
          header('Content-Type: application/json; charset=utf-8');
          echo $output->output;
          exit;
      }
		foreach($output->css_files as $file){
			?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
			<?php
		}
        foreach($output->js_files as $file){
        	?>
            <script src="<?php echo $file; ?>"></script>
        	<?php
        }

     echo $output->output;
?>