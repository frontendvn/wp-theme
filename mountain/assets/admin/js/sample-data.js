( function( $ ) {
	"use strict";

	$.fn.spinnerText = function() {
		return this.each( function() {
			var element = $( this ),
				spinner = $( '> .spinner-text', this ),
				appendText = '.',
				interval = setInterval( function() {
					spinner.text( appendText );

					if ( appendText.length < 3 ) appendText+= '.';
					else appendText = '';

					if ( element.attr( 'data-state' ) == 'done' ) {
						clearInterval( interval );
						spinner.text( '' );
					}
				}, 500 );
		} );
	};

	var SampleDataInstaller = function( container ) {
		this.container = $( container );
		this.tasks = [
			{ 'element': 'li[data-task="import-content"]', 'callback': this.importContent },
			{ 'element': 'li[data-task="download-attachments"]', 'callback': this.downloadAttachments }
		];

		$( '#install-sample-data', this.container ).on( 'click', this.doInstall.bind( this ) );
	};

	SampleDataInstaller.prototype = {
		importContent: function( element ) {
			this._post( 'import-content', { nonce: _sampleDataInfo.nonce }, ( function( content_response ) {
				_sampleDataInfo.manifest = content_response.manifest;

				this._post( 'update-metadata', { nonce: content_response.nonce, manifest: _sampleDataInfo.manifest }, ( function( meta_response ) {
					_sampleDataInfo.nonce = meta_response.nonce;
					_sampleDataInfo.attachments = meta_response.attachment_ids;

					this.doTask();
				} ).bind( this ) );
			} ).bind( this ) );
		},

		downloadAttachments: function( element ) {
			var self        = this;
			var max         = 10;
			var completed   = [];
			var total       = _sampleDataInfo.attachments.length;
			var ids         = _sampleDataInfo.attachments;
			var retryCount  = {};
			var MAX_RETRIES = 3;

			var refresh = function() {
				$( 'li[data-task="download-attachments"] .progress-text' ).text( '(' + completed.length + '/' + total + ')' );				
			};

			var downloadFailed = function( id, response ) {
				console.log( 'Download failed: ' + id );

				if ( retryCount[id] === undefined )
					retryCount[id] = 1;

				if ( retryCount[id] < MAX_RETRIES ) {
					retryCount[id]++;
					ids.push( id );
				}
				else {
					completed.push( id );
				}

				if ( ids.length > 0 )
					download( ids.shift(), downloadSuccess, downloadFailed );
				else if ( completed.length == total )
					self.doTask();
			};

			var download = function( id, successCallback, failedCallback ) {
				var params = {
					id: id,
					nonce: _sampleDataInfo.nonce,
					manifest: _sampleDataInfo.manifest
				};

				self._post( 'download-attachment', params, function( response ) {
					completed.push( id );
					refresh();

					successCallback( id, response );
				}, function( response ) {
					failedCallback( id, response )
				} );
			};

			var downloadSuccess = function( id, response ) {
				if ( response.status == 'error' )
					console.log( response.message );

				if ( ids.length > 0 )
					download( ids.shift(), downloadSuccess, downloadFailed );
				else if ( completed.length == total )
					self.doTask();
			};

			if ( ids.length < max )
				max = ids.length;

			for ( var index = 0; index < max; index++ )
				download( ids.shift(), downloadSuccess, downloadFailed );
		},

		// Get next task and start it
		doTask: function() {
			if ( this.activeElement )
				this.activeElement.attr( 'data-state', 'done' );

			if ( this.tasks.length == 0 ) {
				this.container.attr( 'data-state', 'done' );
				return;
			}

			this.activeTask = this.tasks.shift();
			this.activeElement = $( this.activeTask.element );
			
			this.activeElement.attr( 'data-state', 'running' ).spinnerText();
			this.activeTask.callback.call( this, this.activeElement );
		},

		doInstall: function() {
			if ( confirm( _sampleDataLocalization.confirm_installation ) ) {
				this.container.attr( 'data-state', 'active' );
				this.doTask();
			}
		},

		_post: function( task, params, successCallback, failedCallback ) {
			if ( ! $.isFunction( failedCallback ) )
				failedCallback = function () {};

			$.ajax( ajaxurl, {
				data: $.extend( { action: 'sample_data', step: task }, params ),
				dataType: 'json',
				type: 'post',
				success: successCallback.bind( this ),
				error: failedCallback.bind( this ),
				complete: function ( response ) {}
			} );
		}
	};

	$( function() {
		new SampleDataInstaller( $( '#sample-data-installer' ) );
	} );

} ).call( this, jQuery );