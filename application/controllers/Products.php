<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends CI_Controller {
   /**
    * Get All Data from this method.
    *
    * @return Response
   */
   public function __construct() {
    //load database in autoload libraries 
      parent::__construct(); 
      $this->load->model('ProductsModel');         

   }
   public function index()
   {
       $products=new ProductsModel;
       $data['data']=$products->get_products();
       $this->load->view('includes/header');       
       $this->load->view('products/list',$data);
       $this->load->view('includes/footer');
   }
   public function create()
   {
      $this->load->view('includes/header');
      $this->load->view('products/create');
      $this->load->view('includes/footer');      
   }
   /**
    * Store Data from this method.
    *
    * @return Response
   */
   public function store()
   {

    $this->form_validation->set_rules('title', 'title', 'required');
    $this->form_validation->set_rules('description', 'description', 'required');
    $this->form_validation->set_rules('category', 'category', 'required');
    $this->form_validation->set_rules('publish', 'publish', 'required');
    $this->form_validation->set_rules('type[]', 'type', 'required');


    if ($this->form_validation->run() == FALSE)
                {
                        $this->load->view('products/create');
                }
                else
                {

      $files = $_FILES;  
      $config = array(
      'upload_path' => "./uploads/",
      'allowed_types' => "gif|jpg|png|jpeg|pdf",
      'overwrite' => TRUE,
      'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
      'max_height' => "768",
      'max_width' => "1024"
      );

    $this->load->library('upload', $config);
    if ( ! $this->upload->do_upload('image')) {

         $error = array('error' => $this->upload->display_errors()); 
         $this->load->view('products/create',$error); 
      }else { 
        $this->upload->initialize($config);
        $this->upload->do_upload('image');
        $fileName = $_FILES['image']['name'];
        $ty = $this->input->post('type');
        $t = implode(',', $ty);
        $data = array(
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'category' => $this->input->post('category'),
            'publish' => $this->input->post('publish'),
            'image' => $fileName,
            'type' => $t
        );
        $products=new ProductsModel;
        $result = $products->insert_product($data);
        $message['message'] = $this->session->set_flashdata('message_name', 'Sucessfully created');
        redirect('products',$message);   
      }
}
    }
   /**
    * Edit Data from this method.
    *
    * @return Response
   */
   public function edit($id)
   {
       $product = $this->db->get_where('products', array('id' => $id))->row();
       $this->load->view('includes/header');
       $this->load->view('products/create',array('product'=>$product));
       $this->load->view('includes/footer');   
   }
   /**
    * Update Data from this method.
    *
    * @return Response
   */
   public function update($id)
   {
    $this->form_validation->set_rules('title', 'title', 'required');
    $this->form_validation->set_rules('description', 'description', 'required');
    $this->form_validation->set_rules('category', 'category', 'required');
    $this->form_validation->set_rules('publish', 'publish', 'required');
    $this->form_validation->set_rules('type[]', 'type', 'required');


    if ($this->form_validation->run() == FALSE)
                {
                  redirect('products/edit/'.$id);   
                }
                else
                {

    $product = $this->db->get_where('products', array('id' => $id))->row();
    $fileName;
    $files = $_FILES;  
      $config = array(
      'upload_path' => "./uploads/",
      'allowed_types' => "gif|jpg|png|jpeg|pdf",
      'overwrite' => TRUE,
      'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
      'max_height' => "768",
      'max_width' => "1024"
      );

    $this->load->library('upload', $config);
    if ( ! $this->upload->do_upload('image')) {
         $fileName = $product->image;
      }
      else{
        $this->upload->initialize($config);
        $this->upload->do_upload('image');
        $fileName = $_FILES['image']['name'];
}
        
        $ty = $this->input->post('type');
        $t = implode(',', $ty);
        
        $data = array(
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'category' => $this->input->post('category'),
            'publish' => $this->input->post('publish'),
            'image' => $fileName,
            'type' => $t
        );
       $products=new ProductsModel;
       $products->update_product($id,$data);
        $message['message'] = $this->session->set_flashdata('message_name', 'Sucessfully Updated');
        redirect('products',$message);   
     }
   }
   /**
    * Delete Data from this method.
    *
    * @return Response
   */
   public function delete($id)
   {
       $this->db->where('id', $id);
       $this->db->delete('products');
       redirect(base_url('products'));
   }
}