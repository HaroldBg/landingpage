"use strict";

// Class definition
var KTModalCustomersAdd = function () {
    var submitButton;
    var cancelButton;
	var closeButton;
    var validator;
    var form;
    var modal;

    // Init form inputs
    var handleForm = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validator = FormValidation.formValidation(
			form,
			{
				fields: {
                    'name': {
						validators: {
							notEmpty: {
								message: 'Nom et prenom requis '
							}
						}
					},
                    'email': {
						validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: "L'adresse mail n'est pas valide",
                            },
							notEmpty: {
								message: 'Email requis '
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
					})
				}
			}
		);


		// Action buttons
		submitButton.addEventListener('click', function (e) {
			e.preventDefault();

			// Validate form before submit
			if (validator) {
				validator.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {
						submitButton.setAttribute('data-kt-indicator', 'on');

						// Disable submit button whilst loading
						submitButton.disabled = true;
                        // get form data 
                        var formData = new FormData(form);
                         //  ajax request   	
                        $.ajax({
                            type:"POST",
                            url: "controller/formation.php",
                            data: formData,
                            dataType: "json",
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                if(data.error == false){
                                    
                                // submitButton.removeAttribute('data-kt-indicator');
                                // // Enable submit button after loading
                                // submitButton.disabled = false;
                                    Swal.fire({
                                        text: data.msg,
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Continuer!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function() {
                                        // window.location.href = "app/view/dashboard.php";
                                        location.reload();
                                    });
                                }else{
                                    Swal.fire({
                                        text: data.msg,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Continuer!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                }
                                
                            }
                        }); 						
					} else {
                        Swal.fire({
                            text: "Quelques erreurs détecter veuillez réessayer.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Continuer!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
					}
				});
			}
		});

        cancelButton.addEventListener('click', function (e) {
            e.preventDefault();

            Swal.fire({
                text: "Êtes vous sur de vouloir annuler?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Oui!",
                cancelButtonText: "Non",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    form.reset(); // Reset form	
                    modal.hide(); // Hide modal				
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Votre formulaire n'a pas été réinitialiser!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
        });

		closeButton.addEventListener('click', function(e){
			e.preventDefault();

            Swal.fire({
                text: "Êtes vous sur de vouloir annuler?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Oui!",
                cancelButtonText: "Non",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    form.reset(); // Reset form	
                    modal.hide(); // Hide modal				
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Votre formulaire n'a pas été annuler!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
		})
    }

    return {
        // Public functions
        init: function () {
            // Elements
            modal = new bootstrap.Modal(document.querySelector('#kt_modal_add_customer'));

            form = document.querySelector('#kt_modal_add_customer_form');
            submitButton = form.querySelector('#kt_modal_add_customer_submit');
            cancelButton = form.querySelector('#kt_modal_add_customer_cancel');
			closeButton = form.querySelector('#kt_modal_add_customer_close');

            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
	KTModalCustomersAdd.init();
});