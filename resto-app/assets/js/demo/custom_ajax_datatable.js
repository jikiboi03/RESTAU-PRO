var save_method; //for save method string
         var table;
        $(document).ready(function() {

            //datatables
            table = $('#table').DataTable({ 
         
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
         
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('showlist-customer')?>",
                    "type": "POST",
                },
         
                //Set column definition initialisation properties.
                "columnDefs": [
                { 
                    "targets": [ -1 ], //last column
                    "orderable": false, //set not orderable
                },
                ],
         
            });
         
        });

         
        function add_person()
        {
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
        }
         
        function edit_person(id)
        {
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
         
            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo base_url('edit-customer')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('[name="id"]').val(data.customer_id);
                    $('[name="lastname"]').val(data.lastname);
                    $('[name="firstname"]').val(data.firstname);
                    $('[name="middlename"]').val(data.middlename);
                    $('[name="address"]').val(data.address);
                    $('[name="city"]').val(data.city);
                    $('[name="contact"]').val(data.contact);
                    $('[name="email"]').val(data.email);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title
         
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
        }
         
        function reload_table()
        {
            table.ajax.reload(null,false); //reload datatable ajax 
        }
         
        function save()
        {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 
            var url;
         
            if(save_method == 'add') {
                url = "<?php echo base_url()?>customer/customer_controller/ajax_add";
            } else {
                url = "<?php echo base_url()?>customer/customer_controller/ajax_update";
            }
         
            // ajax adding data to database
            $.ajax({
                url : url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data)
                {
         
                    if(data.status) //if success close modal and reload ajax table
                    {
                        $('#modal_form').modal('hide');
                        reload_table();
                    }
         
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
         
         
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error adding / update data');
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
         
                }
            });
        }
         
        function delete_person(id)
        {
            if(confirm('Are you sure delete this data?'))
            {
                // ajax delete data to database
                $.ajax({
                    url : "<?php echo base_url('delete-customer')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');
                        reload_table();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });
         
            }
        }