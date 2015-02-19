define(["angular", "razor/services/rars", ], function(angular)
{		
    angular.module("extension.communication.mula.contactFormExtended.controller", ["razor.services.rars"])
     
    //load the recaptcha object   
	.service('googleGrecaptcha', ['$q', '$window', function GoogleGrecaptchaService($q, $window) {
		var deferred = $q.defer();
		$window.recaptchaOnloadCallback = function () {
			deferred.resolve();
		};
		var s = document.createElement('script');
		s.src = 'https://www.google.com/recaptcha/api.js?onload=recaptchaOnloadCallback&render=explicit';
		document.body.appendChild(s);
		return deferred.promise;
	}])
    
    .controller("main", ['$scope','rars','googleGrecaptcha', function($scope, rars,googleGrecaptcha)
    {
        $scope.extension = {"type": "communication", "handle": "mula", "extension": "contact-form-extended"};
        $scope.processing = null;
        $scope.robot = null;
        $scope.error = null; 
		var widgetId;
		$scope.valid = false; //for recaptcha, will be true on successfull recaptcha validation
		
        $scope.init = function()
        {
            rars.get("extension/communication/mula/contact-form-extended/settings")
			
			.success(function(data)
            {          	
                $scope.extSettings = angular.fromJson(data.json_settings);    
				//if recaptcha is not used, we must manually set valid to true
				//because the send button will check this
				if (!$scope.extSettings.captcha) {
					$scope.valid = true;
				}
                var grecaptchaCreateParameters;
             	grecaptchaCreateParameters = {
					sitekey: $scope.extSettings.captchakey,
					theme: $scope.extSettings.theme,
					callback: function(r){ 
						$scope.valid = true;	
						$scope.$apply();
					}
				};	
				
				googleGrecaptcha.then(function(){					
					this.widgetId = grecaptcha.render(
						"recaptchacontainer",
						grecaptchaCreateParameters
					);					
				}); 
				
            }).error(function(data, header)
            {
				alert('Error while reading extension settings:'+data);
            });            
        };

        $scope.send = function()
        {
        	
            $scope.processing = true; 
            $scope.error = false;
			$scope.robot = false;
			
			// validate captcha if activated
			if ($scope.extSettings.captcha) {
				$scope.human = ""; //we are not using the are-you-human-method now
	       }
           
            rars.post("extension/communication/mula/contact-form-extended/email", {"signature": $scope.signature, "email": $scope.email, "message": $scope.message, "human": $scope.human, "extension": $scope.extension})
                .success(function(data)
                {
                    $scope.response = true;
                })
                .error(function(data, header) 
                {
                    if (data.response == "robot") $scope.robot = true;
                    else
                    {
                        $scope.error = true;                        
                    }
					if ($scope.extSettings.captcha) {
						grecaptcha.reset(this.widgetId);
					}
					$scope.processing = null;
                }
            );
        };       
    }]);
    


});