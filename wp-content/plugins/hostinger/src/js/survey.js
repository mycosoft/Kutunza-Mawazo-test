import * as Survey from 'survey-jquery'

( function ( $ ) {
	$( document ).on( 'ready', function () {
		let type = 'ai_survey';
		let surveyWrapper = $( '.hts-survey-wrapper' );

		if ( surveyWrapper.hasClass( 'hts-woocommerce-csat' ) ) {
			type = 'woo_survey';
		}

		if ( surveyWrapper.hasClass( 'hts-ai-onboarding-csat' ) ) {
			type = 'ai_onboarding_survey';
		}

		if ( surveyWrapper.length ) {
			$.ajax( {
				url: ajaxurl,
				method: 'POST',
				data: {
					action: 'hostinger_get_survey',
					nonce: ajax_var.nonce,
					type: type
				},
				dataType: 'json',
				success: function ( data ) {
					let questionsCount = $( '#hts-questionsLeft' );
					surveyWrapper.show();
					const survey = new Survey.Model( data );
					survey.focusFirstQuestionAutomatic = false;
					survey.render( "hostinger-feedback-survey" );
					survey.onComplete.add( onSurveyComplete );
					survey.onCurrentPageChanged.add( onPageChanged ); // Add this line
					survey.render( "surveyElement" );

					let answeredQuestions = 0;
					let totalQuestions = survey.getAllQuestions().length;
					if ( totalQuestions >= 2 ) {
						questionsCount.show()
						$( "#hts-allQuestions" ).html( totalQuestions );
					}

					function updateQuestionsLeft () {
						var remaining = answeredQuestions + 1;
						document.getElementById( "hts-currentQuestion" ).textContent = remaining;
					}

					function onPageChanged ( sender, options ) {
						if ( options.isNextPage || options.isPrevPage ) {
							answeredQuestions = survey.currentPageNo;
							updateQuestionsLeft();
						}
					}

					function onSurveyComplete ( sender ) {
						const results = JSON.stringify( sender.data );
						$( '#hts-questionsLeft' ).remove();
						hostinger_submit_survey( results, type );
					}

					updateQuestionsLeft();

				},
				error: function ( xhr, status, error ) {
					console.log( 'AJAX request failed: ' + error );
				}
			} );
		}

		function hostinger_submit_survey ( survey_answers, type ) {
			$.ajax( {
				url: ajaxurl,
				method: 'POST',
				data: {
					action: 'hostinger_submit_survey',
					nonce: ajax_var.nonce,
					survey_results: survey_answers,
					type: type
				},
				dataType: 'json',
				success: function ( data ) {

				},
				error: function ( xhr, status, error ) {
					console.log( 'AJAX request failed: ' + error );
				}
			} );
		}

	} );

} )( jQuery );
