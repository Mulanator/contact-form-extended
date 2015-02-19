require(["angular", "../../extension/communication/mula/contact-form-extended/js/controller"], function(angular)
{
    angular.module("extension.communication.mula.contactFormExtended", ["extension.communication.mula.contactFormExtended.controller"]);
    angular.bootstrap(document.querySelectorAll(".communication-mula-contact-form-extended"), ["extension.communication.mula.contactFormExtended"]);
});