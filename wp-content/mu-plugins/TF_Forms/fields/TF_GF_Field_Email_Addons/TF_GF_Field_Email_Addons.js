'use strict';

var TF_GF_Field_Email_Addons = {

    load_values: function load_values(event, field, form) {
        if ('email' != field.type) return;

        jQuery('.business_email_rules_settings').show();

        if (field['toggle_business_rules_restrict_email_per_entry'] == 'on' || field['toggle_business_rules_restrict_email_per_entry'] == true) {
            jQuery('#toggle_business_rules_restrict_email_per_entry').attr('checked', true);
            jQuery('#toggle_business_rules_restrict_email_per_entry').prop('checked', true);
        } else {
            jQuery('#toggle_business_rules_restrict_email_per_entry').attr('checked', false);
            jQuery('#toggle_business_rules_restrict_email_per_entry').prop('checked', false);
        }

        if (field['toggle_business_rules_restrict_email_per_entry_per_day'] == 'on' || field['toggle_business_rules_restrict_email_per_entry_per_day'] == true) {
            jQuery('#toggle_business_rules_restrict_email_per_entry_per_day').attr('checked', true);
            jQuery('#toggle_business_rules_restrict_email_per_entry_per_day').prop('checked', true);
        } else {
            jQuery('#toggle_business_rules_restrict_email_per_entry_per_day').attr('checked', false);
            jQuery('#toggle_business_rules_restrict_email_per_entry_per_day').prop('checked', false);
        }

        if (field['toggle_business_rules_restrict_email_total_casts'] == 'on' || field['toggle_business_rules_restrict_email_total_casts'] == true) {
            jQuery('#toggle_business_rules_restrict_email_total_casts').attr('checked', true);
            jQuery('#toggle_business_rules_restrict_email_total_casts').prop('checked', true);
        } else {
            jQuery('#toggle_business_rules_restrict_email_total_casts').attr('checked', false);
            jQuery('#toggle_business_rules_restrict_email_total_casts').prop('checked', false);
        }

        TF_GF_Field_Email_Addons.validate_fields();
    },

    validate_fields: function validate_fields(form) {

        var field = field == undefined ? GetSelectedField() : field;
        field['business_rules_restrict_email_per_entry'] = field['business_rules_restrict_email_per_entry'] || '';
        field['business_rules_restrict_email_per_entry_per_day'] = field['business_rules_restrict_email_per_entry_per_day'] || '';
        field['business_rules_restrict_email_total_casts'] = field['business_rules_restrict_email_total_casts'] || '';

        var business_rules_restrict_email_per_entry_min_val = parseInt(jQuery('#business_rules_restrict_email_per_entry').attr('min'));
        business_rules_restrict_email_per_entry_min_val = isNaN(business_rules_restrict_email_per_entry_min_val) ? 1 : business_rules_restrict_email_per_entry_min_val;
        var business_rules_restrict_email_per_entry = parseInt(field['business_rules_restrict_email_per_entry']);
        business_rules_restrict_email_per_entry = isNaN(business_rules_restrict_email_per_entry) || business_rules_restrict_email_per_entry < business_rules_restrict_email_per_entry_min_val ? business_rules_restrict_email_per_entry_min_val : business_rules_restrict_email_per_entry;
        jQuery('#business_rules_restrict_email_per_entry').attr('value', business_rules_restrict_email_per_entry);

        var business_rules_restrict_email_per_entry_per_day_min_val = parseInt(jQuery('#business_rules_restrict_email_per_entry_per_day').attr('min'));
        business_rules_restrict_email_per_entry_per_day_min_val = isNaN(business_rules_restrict_email_per_entry_per_day_min_val) ? 1 : business_rules_restrict_email_per_entry_per_day_min_val;
        var business_rules_restrict_email_per_entry_per_day = parseInt(field['business_rules_restrict_email_per_entry_per_day']);
        business_rules_restrict_email_per_entry_per_day = isNaN(business_rules_restrict_email_per_entry_per_day) || business_rules_restrict_email_per_entry_per_day < business_rules_restrict_email_per_entry_per_day_min_val ? business_rules_restrict_email_per_entry_per_day_min_val : business_rules_restrict_email_per_entry_per_day;
        jQuery('#business_rules_restrict_email_per_entry_per_day').attr('value', business_rules_restrict_email_per_entry_per_day);

        var business_rules_restrict_email_total_casts_min_val = parseInt(jQuery('#business_rules_restrict_email_total_casts').attr('min'));
        business_rules_restrict_email_total_casts_min_val = isNaN(business_rules_restrict_email_total_casts_min_val) ? 1 : business_rules_restrict_email_total_casts_min_val;
        var business_rules_restrict_email_total_casts = parseInt(field['business_rules_restrict_email_total_casts']);
        business_rules_restrict_email_total_casts = isNaN(business_rules_restrict_email_total_casts) || business_rules_restrict_email_total_casts < business_rules_restrict_email_total_casts_min_val ? business_rules_restrict_email_total_casts_min_val : business_rules_restrict_email_total_casts;
        jQuery('#business_rules_restrict_email_total_casts').attr('value', business_rules_restrict_email_total_casts);

        return form;
    },

    init: function init() {
        jQuery(document).bind('gform_load_field_settings', function (event, field, form) {
            TF_GF_Field_Email_Addons.load_values(event, field, form);
        });

        // if( gform ){
        //     gform.addFilter( 'gform_pre_form_editor_save', TF_GF_Field_Email_Addons.validate_fields );
        // }
    }
};

(function () {
    TF_GF_Field_Email_Addons.init();
})();
