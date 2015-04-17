<div class="wpmegm-shortcode-wrapper">
	<h2 class="wpmegm-shortcode-title" data-shortcode="wpme-gmap">[wpme-gmap]</h2>
	<p class="wpmegm-shortcode-desc"><?=__('Configure and Insert short code to place a Google Map in your post or page. You can ignore attributes marked as optional, to use their default values.', 'wpme-google-maps')?></p>
	<div class="wpmegm-controls-group">
		<div class="wpmegm-control">
			<label for="wpmegm-control-address" class="wpmegm-control-label"><?=__('Address', 'wpme-google-maps')?> <span class="required wpmegm-right"><?=__('(required)', 'wpme-google-maps')?></span></label>
			<input type="text" id="wpmegm-control-address" name="wpmegm-param-address" class="wpmegm-control-text wpmegm-param" data-param-name="address" data-required="1" placeholder="This field is required" />
		</div>

		<div class="wpmegm-control">
			<label for="wpmegm-control-width" class="wpmegm-control-label"><?=__('Map Width', 'wpme-google-maps')?> <span class="optional wpmegm-right"><?=__('(optional)', 'wpme-google-maps')?></span></label>
			<input type="text" id="wpmegm-control-width" name="wpmegm-param-width" class="wpmegm-control-text wpmegm-param" data-param-name="width" />
			<span class="notes"><?=__('i.e. 50% or 400px - default is 100%', 'wpme-google-maps')?></span>
		</div>

		<div class="wpmegm-control">
			<label for="wpmegm-control-height" class="wpmegm-control-label"><?=__('Map Height', 'wpme-google-maps')?> <span class="optional wpmegm-right"><?=__('(optional)', 'wpme-google-maps')?></span></label>
			<input type="text" id="wpmegm-control-height" name="wpmegm-param-height" class="wpmegm-control-text wpmegm-param" data-param-name="height" />
			<span class="notes"><?=__('i.e. 50% or 400px - default is 400px', 'wpme-google-maps')?></span>
		</div>

		<div class="wpmegm-control">
			<label for="wpmegm-control-marker" class="wpmegm-control-label"><?=__('Address Marker Icon URL', 'wpme-google-maps')?> <span class="optional wpmegm-right"><?=__('(optional)', 'wpme-google-maps')?></span></label>
			<input type="text" id="wpmegm-control-marker" name="wpmegm-param-marker" class="wpmegm-control-text wpmegm-param" data-param-name="marker" />
			<span class="notes"><?=__('URL to a custom .png/.jpg/.gif image to use as marker icon. Default is Google Map Pin Icon.', 'wpme-google-maps')?></span>
		</div>

		<div class="wpmegm-control">
			<label for="wpmegm-control-zoom" class="wpmegm-control-label"><?=__('Initial Zoom Level', 'wpme-google-maps')?> <span class="optional wpmegm-right"><?=__('(optional)', 'wpme-google-maps')?></span></label>
			<input type="text" id="wpmegm-control-zoom" name="wpmegm-param-zoom" class="wpmegm-control-text wpmegm-param" data-param-name="zoom" />
			<span class="notes"><?=__('Default is 15 - lower value zoom out while higher value zoom in the map.', 'wpme-google-maps')?></span>
		</div>

		<div class="wpmegm-control">
			<label for="wpmegm-control-type" class="wpmegm-control-label"><?=__('Map Type', 'wpme-google-maps')?> <span class="optional wpmegm-right"><?=__('(optional)', 'wpme-google-maps')?></span></label>
			<select id="wpmegm-control-type" name="wpmegm-param-type" class="wpmegm-control-select wpmegm-param" data-param-name="type">
				<option value="">-- Select --</option>
				<option value="HYBRID">HYBRID</option>
				<option value="ROADMAP">ROADMAP (default)</option>
				<option value="SATELLITE">SATELLITE</option>
				<option value="TERRAIN">TERRAIN</option>
			</select>
		</div>

		<div class="wpmegm-control">
			<label for="wpmegm-control-swheel" class="wpmegm-control-label"><?=__('Mouse Scroll Wheel', 'wpme-google-maps')?> <span class="optional wpmegm-right"><?=__('(optional)', 'wpme-google-maps')?></span></label>
			<select id="wpmegm-control-swheel" name="wpmegm-param-swheel" class="wpmegm-control-select wpmegm-param" data-param-name="swheel">
				<option value="">-- Select --</option>
				<option value="disable">Disable (default)</option>
				<option value="enable">Enable</option>
			</select>
		</div>

		<div class="wpmegm-control">
			<label for="wpmegm-control-controls" class="wpmegm-control-label"><?=__('Map Controls', 'wpme-google-maps')?> <span class="optional wpmegm-right"><?=__('(optional)', 'wpme-google-maps')?></span></label>
			<select id="wpmegm-control-controls" name="wpmegm-param-controls" class="wpmegm-control-select wpmegm-param" data-param-name="controls">
				<option value="">-- Select --</option>
				<option value="hide">Hide</option>
				<option value="show">Show (default)</option>
			</select>
		</div>

		<div class="wpmegm-control">
			<label for="wpmegm-control-cache" class="wpmegm-control-label"><?=__('Cache', 'wpme-google-maps')?> <span class="optional wpmegm-right"><?=__('(optional)', 'wpme-google-maps')?></span></label>
			<select id="wpmegm-control-cache" name="wpmegm-param-cache" class="wpmegm-control-select wpmegm-param" data-param-name="cache">
				<option value="">-- Select --</option>
				<option value="disable">Disable</option>
				<option value="enable">Enable (default)</option>
			</select>
			<span class="notes"><?=__('If enabled, stores results in cache for 30 days - which improves speed. If you want to get fresh results every time, do not enable cache.', 'wpme-google-maps')?></span>
		</div>

		<div class="wpmegm-control">
			<label for="wpmegm-control-class" class="wpmegm-control-label"><?=__('CSS: Map DIV Class(es)', 'wpme-google-maps')?> <span class="optional wpmegm-right"><?=__('(optional)', 'wpme-google-maps')?></span></label>
			<input type="text" id="wpmegm-control-class" name="wpmegm-param-class" class="wpmegm-control-text wpmegm-param" data-param-name="class" />
			<span class="notes"><?=__('Default is wpme-gmap', 'wpme-google-maps')?></span>
		</div>

		<div class="wpmegm-control">
			<label for="wpmegm-control-id" class="wpmegm-control-label"><?=__('CSS: Map DIV ID', 'wpme-google-maps')?> <span class="optional wpmegm-right"><?=__('(optional)', 'wpme-google-maps')?></span></label>
			<input type="text" id="wpmegm-control-id" name="wpmegm-param-id" class="wpmegm-control-text wpmegm-param" data-param-name="id" />
			<span class="notes"><?=__('Default is wpme-gmap - do not include # (hash) sign. This ID is also used as map object ID.', 'wpme-google-maps')?></span>
		</div>


		<div class="wpmegm-control separator">
			<button type="button" id="wpmegm-action-insert" class="button button-primary button-large wpmegm-control-button wpmegm-right"><?=__('Insert Short Code', 'wpme-google-maps')?></button>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($){
		wpme_gmaps_insert();
	});
</script>
