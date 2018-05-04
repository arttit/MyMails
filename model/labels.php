<?php 
class labels{
	public function create_labels(){
		$i=1;
		if(isset($_POST['input-add-folder-filter']) && isset($_POST['input-add-folder-name']) && $_POST['input-add-folder-name']!='' && $_POST['input-add-folder-filter']!=''){
			$create_label_name_1 = $_POST['input-add-folder-name'];
			$create_label_search_1 = $_POST['input-add-folder-filter'];
			session_start();
			if(isset($_SESSION['label-name-1'])){
				$i++;
			}
			if(isset($_SESSION['label-name-2'])){
				$i++;
			}
			$_SESSION['label-name-'.$i]=$create_label_name_1;
			$_SESSION['label-filter-'.$i]=$create_label_search_1;
			$i++;
		}
	}
	public function delete_labels(){
		session_start();
		for ($i=0; $i < count($_SESSION) ; $i++) { 
			if(isset($_SESSION['label-filter-'.$i])){
				if($_SESSION['label-filter-'.$i] == $_POST['folder-name']){
					unset($_SESSION['label-filter-'.$i]);
					unset($_SESSION['label-name-'.$i]);
				}
			}
		}
	}
}
?>