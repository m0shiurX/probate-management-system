<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounting', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('field', 128)->nullable();
            $table->double('value')->nullable()->default(0);
            $table->integer('lastModified')->nullable()->default(0);
        });

        Schema::create('accounts', function (Blueprint $table) {
            $table->integer('id', true)->unique('id');
            $table->text('username')->index('username');
            $table->string('api_key')->nullable();
            $table->text('password');
            $table->double('access_level')->default(0);
            $table->integer('is_restricted')->nullable()->default(0);
            $table->integer('company')->index('company');
            $table->text('status');
            $table->integer('last_login');
            $table->integer('last_changed');
            $table->text('email');
            $table->text('name');
            $table->text('surname');
            $table->text('profile_picture');
            $table->text('notes');
            $table->text('account_website');
            $table->text('account_title');
            $table->text('account_add_salutation');
            $table->text('account_add_line1');
            $table->text('account_add_line2');
            $table->text('account_add_county');
            $table->text('account_add_town');
            $table->text('account_add_postcode');
            $table->text('account_workphone');
            $table->text('account_mobilephone');
            $table->text('account_homephone');
            $table->string('uuid')->nullable();
            $table->string('tfa_secret', 254)->nullable();

            $table->primary(['id']);
        });

        Schema::create('accounts_copy', function (Blueprint $table) {
            $table->integer('id', true)->unique('id');
            $table->text('username')->index('username');
            $table->text('password');
            $table->integer('access_level');
            $table->integer('company')->index('company');
            $table->text('status');
            $table->integer('last_login');
            $table->integer('last_changed');
            $table->text('email');
            $table->text('name');
            $table->text('surname');
            $table->text('profile_picture');
            $table->text('notes');
            $table->text('account_website');
            $table->text('account_title');
            $table->text('account_add_salutation');
            $table->text('account_add_line1');
            $table->text('account_add_line2');
            $table->text('account_add_county');
            $table->text('account_add_town');
            $table->text('account_add_postcode');
            $table->text('account_workphone');
            $table->text('account_mobilephone');
            $table->text('account_homephone');

            $table->primary(['id']);
        });

        Schema::create('accounts_extra', function (Blueprint $table) {
            $table->integer('extra_id', true);
            $table->text('account_username');
            $table->text('text_1');
            $table->text('text_2');
            $table->text('text_3');
            $table->integer('last_updated');
        });

        Schema::create('accounts_online', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username', 128)->nullable();
            $table->bigInteger('timestamp')->nullable()->default(0);
        });

        Schema::create('aml_requests', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('type', 128)->nullable();
            $table->integer('case')->nullable()->default(0);
            $table->string('aml_result', 128)->nullable();
            $table->string('aml_name', 128)->nullable();
            $table->string('aml_sent', 1000)->nullable();
            $table->string('aml_dob', 128)->nullable();
            $table->string('aml_pdf', 256)->nullable();
            $table->string('aml_token', 50)->nullable();
            $table->string('aml_by', 128)->nullable();
            $table->timestamp('aml_ts')->nullable()->useCurrent();
        });

        Schema::create('amllogs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('Endpoint', 128)->nullable();
            $table->string('DataSent', 2000)->nullable();
            $table->mediumText('DataReceived')->nullable();
            $table->string('CurlStatus', 128)->nullable();
            $table->string('CurlHeaders', 500)->nullable();
            $table->timestamp('ts')->nullable()->useCurrent();
        });

        Schema::create('api_calls', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('caller', 128)->nullable();
            $table->string('http_method', 128)->nullable();
            $table->string('url', 128)->nullable();
            $table->mediumText('request_body')->nullable();
            $table->mediumText('response_body')->nullable();
            $table->integer('ts')->nullable()->default(0);
        });

        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        Schema::create('case_editing', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('user', 128)->nullable();
            $table->integer('expire_time')->nullable()->default(0);
            $table->bigInteger('case_number')->nullable()->default(0);
            $table->string('case_type', 12)->nullable();
            $table->timestamp('timestamp')->nullable()->useCurrent();
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('from', 128)->nullable();
            $table->string('to', 128)->nullable();
            $table->mediumText('text')->nullable();
            $table->bigInteger('read_timestamp')->nullable()->default(0);
            $table->bigInteger('sent_timestamp')->nullable()->default(0);
        });

        Schema::create('chat_online', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username', 128)->nullable();
            $table->bigInteger('timestamp')->nullable()->default(0);
        });

        Schema::create('client_details', function (Blueprint $table) {
            $table->integer('client_id', true)->unique('client_id');
            $table->integer('client_code')->index('client_code');
            $table->text('client_title');
            $table->text('client_forename');
            $table->string('client_surname', 256)->default('');
            $table->text('client_dob')->nullable();
            $table->integer('client_deceased');
            $table->integer('client_active');
            $table->text('client_salutation');
            $table->text('client_add_line1');
            $table->text('client_add_line2');
            $table->text('client_add_town');
            $table->text('client_add_county');
            $table->text('client_add_postcode');
            $table->text('client_homephone');
            $table->text('client_mobilephone');
            $table->text('client_workphone');
            $table->text('client_email');
            $table->string('person_gdpr_email', 128)->nullable();
            $table->string('person_gdpr_post', 128)->nullable();
            $table->string('person_gdpr_telephone', 128)->nullable();
            $table->string('person_gdpr_opt_in_date', 128)->nullable();
            $table->string('person_gdpr_opt_in_method', 128)->nullable();
            $table->string('person_gdpr_withhold', 128)->nullable();
            $table->string('person_gdpr_withhold_reason', 128)->nullable();
            $table->string('mc_tag', 128)->nullable();
            $table->string('mc_audience', 128)->nullable();

            $table->index(['client_active', 'client_deceased', 'client_id', 'client_surname'], 'client_active');
            $table->primary(['client_id']);
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->integer('client_code', true)->unique('client_id');
            $table->integer('1st_client_id');
            $table->integer('2nd_client_id');
            $table->text('client_policy_type');
            $table->text('client_will_notes');
            $table->text('client_customer_notes');
            $table->text('client_will_done');
            $table->integer('client_LPA_done');
            $table->integer('client_community_trust');
            $table->integer('client_disc_trust');
            $table->integer('client_funeral_plan');
            $table->integer('client_deeds');
            $table->integer('client_total_care');
            $table->string('client_total_care_date', 128)->nullable();
            $table->integer('client_total_care_type')->nullable()->default(0);
            $table->integer('client_LPA');
            $table->integer('client_community_care');
            $table->integer('client_IWC_stored');
            $table->integer('client_IWC_storage_pack_sent');
            $table->integer('client_annual');
            $table->integer('client_TIC');
            $table->integer('client_will_with_society');
            $table->integer('client_return_requested_SWW');
            $table->text('client_agent')->index('client_agent');
            $table->integer('client_company_id')->index('client_company_id');
            $table->double('client_estate_worth');
            $table->integer('client_letter_will');
            $table->integer('client_letter_LPA');
            $table->integer('client_letter_trust');
            $table->integer('client_letter_funeral_plan');
            $table->integer('client_letter_deeds');
            $table->integer('client_created');
            $table->integer('client_last_modified');
            $table->text('client_submitted_by');
            $table->integer('client_iwc_lead')->nullable()->default(0);
            $table->integer('client_storage_box');
            $table->string('client_secondary_consultant', 500)->nullable();
            $table->string('person_gdpr_email', 128)->nullable();
            $table->string('person_gdpr_post', 128)->nullable();
            $table->string('person_gdpr_telephone', 128)->nullable();
            $table->string('person_gdpr_opt_in_date', 128)->nullable();
            $table->string('person_gdpr_opt_in_method', 128)->nullable();
            $table->string('person_gdpr_withhold', 128)->nullable();
            $table->string('person_gdpr_withhold_reason', 128)->nullable();
            $table->string('mc_tag', 128)->nullable();
            $table->string('mc_audience', 128)->nullable();

            $table->primary(['client_code']);
        });

        Schema::create('consultants_list', function (Blueprint $table) {
            $table->text('consultant');
            $table->text('consultant_name');
        });

        Schema::create('document_store', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('case_id', 40)->nullable()->default('0');
            $table->string('case_type', 128)->nullable();
            $table->string('filename', 500)->nullable();
            $table->string('description', 500)->nullable();
            $table->string('token', 500)->nullable();
            $table->integer('deleted')->nullable()->default(0);
            $table->string('submitted_by', 128)->nullable();
            $table->timestamp('ts')->nullable()->useCurrent();
        });

        Schema::create('earnings', function (Blueprint $table) {
            $table->integer('earnings_id', true);
            $table->integer('earnings_code');
            $table->text('earnings_type');
            $table->text('earnings_manager');
            $table->double('earnings_commission');
            $table->text('earnings_commission_paid');
            $table->text('earnings_json');
            $table->integer('earnings_last_changed');
        });

        Schema::create('email_templates', function (Blueprint $table) {
            $table->integer('template_id', true);
            $table->text('template_name');
            $table->mediumText('template_content');
            $table->text('template_creator');
            $table->integer('template_type');
            $table->text('template_attachment');

            $table->unique(['template_id'], 'template_id');
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('forename', 256)->nullable();
            $table->string('middlename', 256)->nullable();
            $table->string('surname', 256)->nullable();
            $table->string('dod', 128)->nullable();
            $table->string('add_line1', 256)->nullable();
            $table->string('add_line2', 256)->nullable();
            $table->string('add_town', 256)->nullable();
            $table->string('add_county', 256)->nullable();
            $table->string('add_postcode', 128)->nullable();
            $table->text('joint_assets')->nullable();
            $table->text('sole_assets')->nullable();
            $table->string('other_main_contact', 128)->nullable();
            $table->string('other_title', 128)->nullable();
            $table->string('other_forename', 256)->nullable();
            $table->string('other_surname', 256)->nullable();
            $table->string('other_relationship', 256)->nullable();
            $table->string('other_email', 256)->nullable();
            $table->string('other_homephone', 256)->nullable();
            $table->string('other_mobilephone', 256)->nullable();
            $table->string('other_salutation', 256)->nullable();
            $table->string('other_add_line1', 256)->nullable();
            $table->string('other_add_line2', 256)->nullable();
            $table->string('other_add_county', 256)->nullable();
            $table->string('other_add_town', 256)->nullable();
            $table->string('other_add_postcode', 256)->nullable();
            $table->string('other_permission', 128)->nullable();
            $table->string('case_status', 128)->nullable();
            $table->integer('partner_id')->nullable()->default(0);
            $table->string('submitted_by', 128)->nullable();
            $table->string('assigned_to', 128)->nullable();
            $table->integer('probate_id')->nullable();
            $table->integer('will_client')->nullable()->default(0);
            $table->string('contact_date', 128)->nullable()->default('0');
            $table->string('quote_amount', 128)->nullable();
            $table->text('office_notes')->nullable();
            $table->text('general_notes')->nullable();
            $table->string('current_position', 526)->nullable();
            $table->string('lead_reference', 256)->nullable();
            $table->timestamp('date_created')->nullable();
            $table->timestamp('last_updated')->useCurrentOnUpdate()->nullable();
        });

        Schema::create('leads_executors', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('lead_id')->nullable()->default(0);
            $table->integer('exec_number')->nullable()->default(0);
            $table->string('title', 128)->nullable();
            $table->string('forename', 256)->nullable();
            $table->string('surname', 256)->nullable();
            $table->string('relationship', 256)->nullable();
            $table->string('email', 256)->nullable();
            $table->string('homephone', 128)->nullable();
            $table->string('mobilephone', 128)->nullable();
            $table->string('salutation', 256)->nullable();
            $table->string('add_line1', 256)->nullable();
            $table->string('add_line2', 256)->nullable();
            $table->string('add_town', 256)->nullable();
            $table->string('add_county', 256)->nullable();
            $table->string('add_postcode', 256)->nullable();
            $table->text('notes')->nullable();
            $table->string('status', 128)->nullable();
        });

        Schema::create('login_logs', function (Blueprint $table) {
            $table->integer('id', true)->unique('id');
            $table->text('username');
            $table->integer('timestamp');
            $table->text('ip');
            $table->text('status');

            $table->primary(['id']);
        });

        Schema::create('marketing_emails', function (Blueprint $table) {
            $table->integer('email_id', true);
            $table->text('email_type');
            $table->integer('email_client_code');
            $table->text('email_to');
            $table->text('email_by');
            $table->text('email_subject');
            $table->text('email_content');
            $table->integer('email_timestamp');
            $table->text('email_token');
            $table->integer('email_read')->default(0);
        });

        Schema::create('marketing_letters', function (Blueprint $table) {
            $table->integer('letter_id', true)->unique('letter_id');
            $table->text('letter_client_type');
            $table->integer('letter_client_id');
            $table->text('letter_type');
            $table->text('letter_sent_by');
            $table->integer('letter_date');

            $table->primary(['letter_id']);
        });

        Schema::create('mc_lists', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('list_name', 128)->nullable();
            $table->string('list_id', 128)->nullable();
            $table->string('list_tags', 1000)->nullable();
        });

        Schema::create('menus', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('parent_id')->default(0);
            $table->integer('menu_order');
            $table->integer('visible')->default(1);
            $table->string('name', 50);
            $table->string('icon', 50)->nullable();
            $table->string('route', 50);
        });

        Schema::create('misc_clients', function (Blueprint $table) {
            $table->integer('misc_id', true);
            $table->text('misc_title');
            $table->text('misc_forename');
            $table->text('misc_surname');
            $table->text('misc_homephone');
            $table->text('misc_email');
            $table->text('misc_mobilephone');
            $table->text('misc_dob');
            $table->text('misc_salutation');
            $table->text('misc_add_line1');
            $table->text('misc_add_line2');
            $table->text('misc_add_town');
            $table->text('misc_add_county');
            $table->text('misc_add_postcode');
            $table->integer('misc_storage');
            $table->text('misc_storage_notes');
            $table->text('misc_notes');
            $table->integer('misc_date_added');
            $table->integer('misc_company_id');
            $table->text('misc_case_manager');
            $table->integer('misc_last_changed');
            $table->integer('misc_case_status')->nullable()->default(1);
            $table->text('misc_submitted_by');
            $table->string('person_gdpr_email', 128)->nullable();
            $table->string('person_gdpr_post', 128)->nullable();
            $table->string('person_gdpr_telephone', 128)->nullable();
            $table->string('person_gdpr_opt_in_date', 128)->nullable();
            $table->string('person_gdpr_opt_in_method', 128)->nullable();
            $table->string('person_gdpr_withhold', 128)->nullable();
            $table->string('person_gdpr_withhold_reason', 128)->nullable();
            $table->string('mc_tag', 128)->nullable();
            $table->string('mc_audience', 128)->nullable();
        });

        Schema::create('overseas_assets', function (Blueprint $table) {
            $table->integer('overseas_asset_id', true);
            $table->text('overseas_code');
            $table->text('overseas_asset_type');
            $table->text('overseas_asset_acc_number');
            $table->string('overseas_asset_currency', 10)->default('¬£');
            $table->double('overseas_asset_amount');
            $table->text('overseas_asset_value');
            $table->text('overseas_asset_date');
            $table->text('overseas_asset_submitted_by');
            $table->integer('overseas_asset_date_added');
        });

        Schema::create('overseas_clients', function (Blueprint $table) {
            $table->integer('overseas_id', true);
            $table->string('overseas_case_number', 128)->nullable();
            $table->string('overseas_case_name', 256)->nullable();
            $table->mediumText('overseas_assets_to_be_dealt_w')->nullable();
            $table->string('overseas_case_type', 256)->nullable();
            $table->text('overseas_client_title');
            $table->text('overseas_client_forename');
            $table->text('overseas_client_surname');
            $table->text('overseas_client_dob');
            $table->integer('overseas_client_deceased')->default(0);
            $table->text('overseas_client_dod');
            $table->text('overseas_client_add_line1');
            $table->text('overseas_client_add_line2');
            $table->text('overseas_client_add_town');
            $table->text('overseas_client_add_county');
            $table->text('overseas_client_add_postcode');
            $table->integer('overseas_client_storage_box');
            $table->text('overseas_client_notes');
            $table->integer('overseas_submitter_type');
            $table->text('overseas_submitter_name');
            $table->text('overseas_submitter_firm_name');
            $table->text('overseas_submitter_email');
            $table->text('overseas_submitter_phone');
            $table->text('overseas_submitter_add_line1');
            $table->text('overseas_submitter_add_line2');
            $table->text('overseas_submitter_add_town');
            $table->text('overseas_submitter_add_county');
            $table->text('overseas_submitter_add_postcode');
            $table->text('overseas_company_id');
            $table->text('overseas_case_manager');
            $table->integer('overseas_case_status')->default(1);
            $table->text('overseas_submitted_by');
            $table->integer('overseas_date_added');
            $table->integer('overseas_last_changed');
        });

        Schema::create('overseas_mg', function (Blueprint $table) {
            $table->integer('mg_id', true);
            $table->longText('mg_json');
            $table->integer('mg_last_modified');
            $table->integer('mg_count')->nullable()->default(0);
        });

        Schema::create('overseas_persons', function (Blueprint $table) {
            $table->integer('overseas_person_id', true);
            $table->integer('overseas_id');
            $table->text('overseas_person_type');
            $table->integer('overseas_exec_number');
            $table->integer('overseas_person_aml')->nullable()->default(0);
            $table->text('overseas_person_title');
            $table->text('overseas_person_forename');
            $table->text('overseas_person_surname');
            $table->text('overseas_person_dob');
            $table->integer('overseas_person_age');
            $table->text('overseas_person_add_salutation');
            $table->text('overseas_person_add_line1');
            $table->text('overseas_person_add_line2');
            $table->text('overseas_person_add_town');
            $table->text('overseas_person_add_county');
            $table->text('overseas_person_add_postcode');
            $table->text('overseas_person_email');
            $table->text('overseas_person_homephone');
            $table->text('overseas_person_workphone');
            $table->text('overseas_person_mobilephone');
            $table->integer('overseas_person_id_checked');
            $table->integer('overseas_person_bankruptcy_checked');
            $table->string('person_gdpr_email', 128)->nullable();
            $table->string('person_gdpr_post', 128)->nullable();
            $table->string('person_gdpr_telephone', 128)->nullable();
            $table->string('person_gdpr_opt_in_date', 128)->nullable();
            $table->string('person_gdpr_opt_in_method', 128)->nullable();
            $table->string('person_gdpr_withhold', 128)->nullable();
            $table->string('person_gdpr_withhold_reason', 128)->nullable();
            $table->string('mc_tag', 128)->nullable();
            $table->string('mc_audience', 128)->nullable();
        });

        Schema::create('overseas_type_status', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('overseas_id')->default(0)->index('oid');
            $table->bigInteger('forms_created_and_sent')->nullable()->default(0);
            $table->bigInteger('forms_signed')->nullable()->default(0);
            $table->bigInteger('id_verified_msg_affixed')->nullable()->default(0);
            $table->bigInteger('couriered_to_agent')->nullable()->default(0);
            $table->bigInteger('new_statement_received')->nullable()->default(0);
            $table->bigInteger('couriered_to_irs')->nullable()->default(0);
            $table->bigInteger('tax_clearance_received')->nullable()->default(0);
            $table->bigInteger('couriered_tax_clearence_to_agent')->nullable()->default(0);
        });

        Schema::create('partners', function (Blueprint $table) {
            $table->integer('id', true)->unique('id');
            $table->string('company_name', 256)->default('');
            $table->text('address_1');
            $table->text('address_2');
            $table->text('city');
            $table->text('postcode');
            $table->text('phone_number');
            $table->text('company_email');
            $table->text('date_added');
            $table->string('smart_search_api_company', 256)->nullable();
            $table->string('smart_search_api_username', 256)->nullable();
            $table->string('smart_search_api_key', 256)->nullable();

            $table->primary(['id']);
            $table->index(['company_name', 'id'], 'ss');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->integer('payment_id', true);
            $table->text('payment_agent');
            $table->integer('payment_amount');
            $table->text('payment_authorized_by');
            $table->integer('payment_date');
            $table->text('payment_notes');
        });

        Schema::create('persons', function (Blueprint $table) {
            $table->integer('person_id', true)->unique('person_id');
            $table->integer('client_code');
            $table->text('person_type');
            $table->integer('person_exec_number');
            $table->text('person_title');
            $table->text('person_forename');
            $table->text('person_surname');
            $table->text('person_dob');
            $table->text('person_salutation');
            $table->text('person_add_line1');
            $table->text('person_add_line2');
            $table->text('person_add_town');
            $table->text('person_add_county');
            $table->text('person_add_postcode');
            $table->text('person_homephone');
            $table->text('person_mobilephone');
            $table->text('person_workphone');
            $table->text('person_email');
            $table->integer('person_is_IWC');
            $table->integer('person_is_person');
            $table->integer('person_is_executor');
            $table->integer('person_for');
            $table->integer('person_extra_val');
            $table->string('person_relationship', 128)->nullable();
            $table->text('person_notes')->nullable();
            $table->string('person_exec_status', 128)->nullable();
            $table->string('person_gdpr_email', 128)->nullable();
            $table->string('person_gdpr_post', 128)->nullable();
            $table->string('person_gdpr_telephone', 128)->nullable();
            $table->string('person_gdpr_opt_in_date', 128)->nullable();
            $table->string('person_gdpr_opt_in_method', 128)->nullable();
            $table->string('person_gdpr_withhold', 128)->nullable();
            $table->string('person_gdpr_withhold_reason', 128)->nullable();
            $table->string('mc_audience', 128)->nullable();
            $table->string('mc_tag', 128)->nullable();

            $table->primary(['person_id']);
        });

        Schema::create('prefil_companies', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('company', 128)->nullable();
            $table->string('main_contact', 128)->nullable();
            $table->string('address')->nullable();
            $table->string('email', 128)->nullable();
            $table->string('telephone', 128)->nullable();
            $table->string('notes')->nullable();
            $table->string('sections')->nullable();
            $table->timestamp('ts')->nullable()->useCurrent();
        });

        Schema::create('probate_acc_assets', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('probate_code')->default(0);
            $table->string('acc_asset_type', 128)->nullable();
            $table->string('acc_asset_text')->nullable();
            $table->double('acc_asset_value')->nullable()->default(0);
            $table->double('acc_asset_realised')->nullable()->default(0);
            $table->double('acc_asset_interest')->nullable()->default(0);
            $table->string('acc_asset_howDealt')->nullable();
            $table->timestamp('acc_asset_timestamp')->nullable()->useCurrent();

            $table->index(['acc_asset_type', 'probate_code'], 'main');
        });

        Schema::create('probate_acc_distribution', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('probate_code')->default(0);
            $table->string('acc_distribution_type', 128)->nullable();
            $table->string('acc_distribution_beneficiary', 128)->nullable();
            $table->string('acc_distribution_subtype', 128)->nullable();
            $table->string('acc_distribution_description')->nullable();
            $table->double('acc_distribution_percentage')->nullable()->default(1);
            $table->string('acc_distribution_value', 128)->nullable();
        });

        Schema::create('probate_acc_ledger', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('probate_code');
            $table->string('acc_ledger_bacs_or_cheque', 128)->nullable();
            $table->integer('acc_ledger_cheque_id')->nullable()->default(0);
            $table->string('acc_ledger_type', 128)->nullable();
            $table->string('acc_ledger_date', 128)->nullable();
            $table->string('acc_ledger_text')->nullable();
            $table->double('acc_ledger_value')->nullable()->default(0);
            $table->string('acc_ledger_reason')->nullable();
            $table->string('acc_ledger_cleared', 128)->nullable();
            $table->integer('acc_ledger_approved')->nullable()->default(0);
            $table->string('acc_ledger_approved_date', 128)->nullable();
            $table->timestamp('acc_ledger_timestamp')->useCurrentOnUpdate()->nullable()->useCurrent();

            $table->index(['probate_code', 'acc_ledger_type'], 'idx_probate_code_acc_ledger_type');
        });

        Schema::create('probate_acc_liabilities', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('probate_code');
            $table->string('acc_liability_type', 128)->nullable()->default('Liabilities');
            $table->string('acc_liability_date', 128)->nullable();
            $table->string('acc_liability_text')->nullable();
            $table->double('acc_liability_value')->nullable()->default(0);
            $table->double('acc_liability_paid')->nullable()->default(0);
            $table->string('acc_liability_howDealt')->nullable();
            $table->timestamp('acc_liability_timestamp')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('acc_liability_upsell', 128)->nullable();
        });

        Schema::create('probate_acc_request_payment', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('probate_code')->nullable()->default(0);
            $table->string('acc_request_type', 128)->nullable();
            $table->string('acc_request_date_cleared', 128)->nullable();
            $table->string('acc_request_method', 128)->nullable();
            $table->string('acc_request_cheque_no', 128)->nullable();
            $table->string('acc_request_date_requested', 128)->nullable();
            $table->string('acc_request_by', 128)->nullable();
            $table->string('acc_request_date_authorised', 128)->nullable();
            $table->integer('acc_request_approved')->nullable()->default(0);
            $table->string('acc_request_payee', 128)->nullable();
            $table->double('acc_request_amount')->nullable()->default(0);
            $table->string('acc_request_reason')->nullable();
            $table->string('acc_request_sort_code', 128)->nullable();
            $table->string('acc_request_account_no', 128)->nullable();
            $table->string('acc_request_reference', 128)->nullable();
            $table->integer('acc_request_ledger_id')->nullable()->default(0);
            $table->timestamp('acc_updated')->useCurrentOnUpdate()->nullable();
        });

        Schema::create('probate_admin_spreadsheet', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('probate_id')->nullable()->default(0);
            $table->string('type', 128)->nullable();
            $table->string('value', 2000)->nullable();
            $table->timestamp('ts')->useCurrentOnUpdate()->nullable();
            $table->integer('edited')->nullable()->default(0);
        });

        Schema::create('probate_assets', function (Blueprint $table) {
            $table->integer('probate_asset_id', true);
            $table->text('probate_code');
            $table->text('probate_asset_type');
            $table->text('probate_asset_joint');
            $table->text('probate_asset_acc_number');
            $table->text('probate_asset_value');
            $table->text('probate_asset_date');
            $table->text('probate_asset_submitted_by');
            $table->integer('probate_asset_date_added');
        });

        Schema::create('probate_case_status', function (Blueprint $table) {
            $table->integer('status_id', true);
            $table->integer('probate_code');
            $table->text('status_q1');
            $table->text('status_q2');
            $table->text('status_q3');
            $table->text('status_q4');
            $table->text('status_q5');
            $table->text('status_q6');
            $table->text('status_q7');
            $table->text('status_q8');
            $table->text('status_q9');
            $table->text('status_q10');
            $table->text('status_q11');
            $table->text('status_q12');
            $table->text('status_q13');
            $table->text('status_q14');
            $table->text('status_q15');
            $table->text('status_q16');
            $table->text('status_q17');
            $table->text('status_q18');
            $table->text('status_q19');
            $table->string('status_q20', 20);
            $table->string('status_q21', 20);
            $table->text('status_dow')->nullable();
            $table->text('status_notes');
            $table->integer('status_last_updated');
        });

        Schema::create('probate_clients', function (Blueprint $table) {
            $table->integer('probate_id', true);
            $table->text('probate_client_title');
            $table->text('probate_client_forename');
            $table->string('probate_client_middlename', 128)->nullable();
            $table->text('probate_client_surname');
            $table->text('probate_client_dob');
            $table->text('probate_client_dod');
            $table->text('probate_client_add_line1');
            $table->text('probate_client_add_line2');
            $table->text('probate_client_add_town');
            $table->text('probate_client_add_county');
            $table->text('probate_client_add_postcode');
            $table->integer('probate_client_storage_box');
            $table->text('probate_client_notes');
            $table->text('probate_client_nino');
            $table->string('probate_iwc_consultant', 128)->nullable();
            $table->text('probate_company_id');
            $table->text('probate_case_manager');
            $table->text('probate_submitted_by');
            $table->integer('probate_date_added');
            $table->integer('probate_case_status')->default(1);
            $table->string('probate_case_service', 250)->nullable();
            $table->string('probate_estate_notes', 800)->nullable();
            $table->integer('probate_ledger_account')->nullable()->default(2);
            $table->string('probate_secondary_consultant', 500)->nullable();
            $table->string('probate_od_explanation', 1000)->nullable();
            $table->integer('probate_od_ts')->nullable()->default(0);
            $table->integer('probate_last_changed');
            $table->string('probate_covid', 128)->nullable();
            $table->string('unnamedColumn', 128)->nullable();
            $table->integer('probate_lead')->nullable()->default(0);

            $table->index(['probate_id', 'probate_iwc_consultant', 'probate_case_status'], 'probate_id');
        });

        Schema::create('probate_deleted', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('probate_code', 128)->nullable();
            $table->text('probate_json')->nullable();
            $table->timestamp('detelet_at')->nullable()->useCurrent();
        });

        Schema::create('probate_persons', function (Blueprint $table) {
            $table->integer('probate_person_id', true);
            $table->integer('probate_id');
            $table->text('probate_person_type');
            $table->integer('probate_exec_number');
            $table->integer('probate_person_aml')->nullable();
            $table->text('probate_person_title');
            $table->text('probate_person_forename');
            $table->text('probate_person_middlename')->nullable();
            $table->text('probate_person_surname');
            $table->text('probate_person_dob');
            $table->integer('probate_person_age');
            $table->text('probate_person_add_salutation');
            $table->text('probate_person_add_line1');
            $table->text('probate_person_add_line2');
            $table->text('probate_person_add_town');
            $table->text('probate_person_add_county');
            $table->text('probate_person_add_postcode');
            $table->text('probate_person_email');
            $table->text('probate_person_homephone');
            $table->text('probate_person_workphone');
            $table->text('probate_person_mobilephone');
            $table->integer('probate_person_id_checked');
            $table->integer('probate_person_bankruptcy_checked');
            $table->string('probate_person_relationship', 128)->nullable();
            $table->text('probate_person_notes')->nullable();
            $table->string('probate_person_exec_status', 128)->nullable();
            $table->string('probate_person_acc_no', 128)->nullable();
            $table->string('probate_person_sort_code', 128)->nullable();
            $table->string('probate_gdpr_email', 128)->nullable();
            $table->string('probate_gdpr_post', 128)->nullable();
            $table->string('probate_gdpr_telephone', 128)->nullable();
            $table->string('probate_gdpr_opt_in_date', 128)->nullable();
            $table->string('probate_gdpr_opt_in_method', 128)->nullable();
            $table->string('probate_gdpr_withhold', 128)->nullable();
            $table->string('probate_gdpr_withhold_reason', 128)->nullable();
            $table->string('mc_tag', 128)->nullable();
            $table->string('mc_audience', 128)->nullable();
        });

        Schema::create('probate_property', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('probate_code');
            $table->string('prop_stat_sold', 3)->nullable();
            $table->string('prop_stat_selling', 3)->nullable();
            $table->string('prop_stat_transferring', 3)->nullable();
            $table->string('prop_stat_cleared', 3)->nullable();
            $table->string('prop_stat_drained', 3)->nullable();
            $table->string('prop_stat_insured', 3)->nullable();
            $table->string('prop_add_line1', 128)->nullable();
            $table->string('prop_add_line2', 128)->nullable();
            $table->string('prop_add_town', 128)->nullable();
            $table->string('prop_add_county', 128)->nullable();
            $table->string('prop_add_postcode', 128)->nullable();
            $table->string('prop_add_title', 128)->nullable();
            $table->string('prop_ins_date_from', 128)->nullable();
            $table->string('prop_ins_date_expired', 128)->nullable();
            $table->string('prop_keys_who', 400)->nullable();
            $table->string('prop_val_date_instructed', 128)->nullable();
            $table->string('prop_val_date', 128)->nullable();
            $table->string('prop_age_date_instructed', 128)->nullable();
            $table->string('prop_cle_date_instructed', 128)->nullable();
            $table->string('prop_cle_date', 128)->nullable();
            $table->string('prop_notes', 1500)->nullable();
            $table->string('prop_ins_arr', 700)->nullable()->default('{"prop_contact":"","prop_company":"","prop_address":"","prop_tel":"","prop_email":""}');
            $table->string('prop_val_arr', 700)->nullable()->default('{"prop_contact":"","prop_company":"","prop_address":"","prop_tel":"","prop_email":""}');
            $table->string('prop_age_arr', 700)->nullable()->default('{"prop_contact":"","prop_company":"","prop_address":"","prop_tel":"","prop_email":""}');
            $table->string('prop_sol_arr', 700)->nullable()->default('{"prop_contact":"","prop_company":"","prop_address":"","prop_tel":"","prop_email":""}');
            $table->string('prop_cle_arr', 700)->nullable()->default('{"prop_contact":"","prop_company":"","prop_address":"","prop_tel":"","prop_email":""}');
        });

        Schema::create('products', function (Blueprint $table) {
            $table->integer('product_id', true);
            $table->text('product_name');
            $table->integer('product_time');
            $table->text('product_system');
            $table->text('product_description');
            $table->integer('product_price');
            $table->integer('product_date_added');
            $table->integer('product_recurring');
            $table->integer('product_active')->default(1);
            $table->text('product_design');
        });

        Schema::create('qbo_invoice_request', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('invoice_type', 128)->nullable()->default('invoice');
            $table->string('type', 128)->nullable();
            $table->integer('code')->nullable()->default(0);
            $table->string('invoice_to', 1000)->nullable();
            $table->string('services', 1000)->nullable();
            $table->string('qbo_id', 128)->nullable();
            $table->string('qbo_pdf', 128)->nullable();
            $table->decimal('invoice_total_value', 10)->nullable()->default(0);
            $table->string('reference', 128)->nullable();
            $table->integer('approved')->nullable()->default(0);
            $table->integer('sent')->nullable()->default(0);
            $table->integer('use_memo')->nullable()->default(0);
            $table->string('requested_by', 128)->nullable();
            $table->timestamp('requested_ts')->nullable()->useCurrent();
            $table->bigInteger('approved_ts')->nullable()->default(0);
        });

        Schema::create('qbo_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('item_id')->default(0);
            $table->string('item_category')->nullable();
            $table->string('item_name')->nullable();
            $table->decimal('item_price', 10)->nullable()->default(0);
            $table->integer('item_tax_ref')->nullable()->default(0);
            $table->timestamp('item_last_updated_time')->nullable();

            $table->primary(['id', 'item_id']);
        });

        Schema::create('qbo_tokens', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('type', 128)->nullable();
            $table->mediumText('token')->nullable();
            $table->timestamp('created_ts')->nullable()->useCurrent();
            $table->integer('expires_ts')->nullable()->default(0);
        });

        Schema::create('query_logs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('query_username');
            $table->integer('query_company');
            $table->text('query_type');
            $table->text('query_what');
            $table->integer('query_timestamp');
        });

        Schema::create('quote', function (Blueprint $table) {
            $table->integer('quote_id', true);
            $table->string('quote_type', 128)->nullable();
            $table->integer('quote_status')->nullable()->default(0);
            $table->string('quote_title', 128)->nullable();
            $table->string('quote_first_name', 128)->nullable();
            $table->string('quote_last_name', 128)->nullable();
            $table->string('quote_dob', 128)->nullable();
            $table->string('quote_email', 128)->nullable();
            $table->string('quote_contact_number', 128)->nullable();
            $table->string('quote_add_salutation', 128)->nullable();
            $table->string('quote_add_line1', 128)->nullable();
            $table->string('quote_add_line2', 128)->nullable();
            $table->string('quote_add_town', 128)->nullable();
            $table->string('quote_add_county', 128)->nullable();
            $table->string('quote_add_postcode', 128)->nullable();
            $table->string('quote_agent', 128)->nullable();
            $table->string('quote_company', 128)->nullable();
            $table->bigInteger('quote_last_contact')->nullable()->default(0);
            $table->bigInteger('quote_ts')->nullable()->default(0);
            $table->mediumText('quote_notes')->nullable();
            $table->double('quote_price')->nullable()->default(0);
            $table->integer('quote_send_email')->nullable()->default(1);
            $table->integer('quote_days')->nullable()->default(7);
            $table->integer('quote_opted_out')->nullable()->default(0);
            $table->mediumText('quote_email_body')->nullable();
            $table->mediumText('quote_email_attachments')->nullable();
            $table->string('quote_token', 128)->nullable();
            $table->string('quote_submitted_by', 128)->nullable();
        });

        Schema::create('record_changes', function (Blueprint $table) {
            $table->integer('change_id', true);
            $table->integer('change_client_code');
            $table->text('change_type');
            $table->integer('change_count');
            $table->mediumText('change_fields');
            $table->mediumText('change_json');
            $table->text('change_by');
            $table->integer('change_timestamp');
        });

        Schema::create('sandbox_client_details', function (Blueprint $table) {
            $table->integer('client_id', true)->unique('client_id');
            $table->integer('client_code');
            $table->text('client_title');
            $table->text('client_forename');
            $table->text('client_surname');
            $table->text('client_dob')->nullable();
            $table->integer('client_deceased');
            $table->integer('client_active');
            $table->text('client_salutation');
            $table->text('client_add_line1');
            $table->text('client_add_line2');
            $table->text('client_add_town');
            $table->text('client_add_county');
            $table->text('client_add_postcode');
            $table->text('client_homephone');
            $table->text('client_mobilephone');
            $table->text('client_workphone');
            $table->text('client_email');

            $table->index(['client_id'], 'client_id_2');
            $table->primary(['client_id']);
        });

        Schema::create('sandbox_clients', function (Blueprint $table) {
            $table->integer('client_code', true)->unique('client_code');
            $table->integer('1st_client_id');
            $table->integer('2nd_client_id');
            $table->text('client_policy_type');
            $table->text('client_will_notes');
            $table->text('client_customer_notes');
            $table->text('client_will_done');
            $table->integer('client_LPA_done');
            $table->integer('client_community_trust');
            $table->integer('client_disc_trust');
            $table->integer('client_funeral_plan');
            $table->integer('client_deeds');
            $table->integer('client_total_care');
            $table->string('client_total_care_date', 128)->nullable();
            $table->integer('client_total_care_type')->nullable()->default(0);
            $table->integer('client_LPA');
            $table->integer('client_community_care');
            $table->integer('client_IWC_stored');
            $table->integer('client_IWC_storage_pack_sent');
            $table->integer('client_annual');
            $table->integer('client_TIC');
            $table->integer('client_will_with_society');
            $table->integer('client_return_requested_SWW');
            $table->text('client_agent');
            $table->integer('client_company_id');
            $table->double('client_estate_worth');
            $table->integer('client_letter_will');
            $table->integer('client_letter_LPA');
            $table->integer('client_letter_trust');
            $table->integer('client_letter_funeral_plan');
            $table->integer('client_letter_deeds');
            $table->integer('client_created');
            $table->integer('client_last_modified');
            $table->text('client_submitted_by');
            $table->integer('client_storage_box');
            $table->integer('client_iwc_lead')->nullable()->default(0);
            $table->string('client_secondary_consultant', 500)->nullable();

            $table->primary(['client_code']);
        });

        Schema::create('sandbox_persons', function (Blueprint $table) {
            $table->integer('person_id', true)->unique('person_id');
            $table->integer('client_code');
            $table->text('person_type');
            $table->integer('person_exec_number');
            $table->text('person_title');
            $table->text('person_forename');
            $table->text('person_surname');
            $table->text('person_dob');
            $table->text('person_salutation');
            $table->text('person_add_line1');
            $table->text('person_add_line2');
            $table->text('person_add_town');
            $table->text('person_add_county');
            $table->text('person_add_postcode');
            $table->text('person_homephone');
            $table->text('person_mobilephone');
            $table->text('person_workphone');
            $table->text('person_email');
            $table->integer('person_is_IWC');
            $table->integer('person_is_person');
            $table->integer('person_is_executor');
            $table->integer('person_for');
            $table->integer('person_extra_val');
            $table->string('person_relationship', 128)->nullable();
            $table->text('person_notes')->nullable();
            $table->string('person_exec_status', 128)->nullable();

            $table->primary(['person_id']);
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('staff_holidays', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username', 50);
            $table->integer('start');
            $table->integer('end');
            $table->integer('working_days');
            $table->integer('date_added');
            $table->string('type', 128)->nullable();
            $table->string('status', 128)->nullable()->default('pending');
        });

        Schema::create('storage_box', function (Blueprint $table) {
            $table->integer('storage_id', true);
            $table->integer('client_code');
            $table->text('storage_doc_type');
            $table->integer('storage_box_number');
            $table->text('storage_date');
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->integer('subscription_id', true);
            $table->integer('account_id');
            $table->integer('product_id');
            $table->integer('subscription_date_purchased');
            $table->text('subscription_transaction');
            $table->integer('subscription_date_expired');

            $table->unique(['subscription_id'], 'subscription_id');
        });

        Schema::create('templates', function (Blueprint $table) {
            $table->integer('template_id', true);
            $table->text('template_name');
            $table->text('template_file');
            $table->text('template_folder');
            $table->text('template_creator');
            $table->integer('template_type');

            $table->unique(['template_id'], 'template_id');
        });

        Schema::create('templates_done', function (Blueprint $table) {
            $table->integer('template_done_id', true);
            $table->text('template_done_name');
            $table->integer('template_done_for');
            $table->text('template_done_token');
            $table->text('template_done_file');
            $table->text('template_done_date');
            $table->text('template_done_person');

            $table->unique(['template_done_id'], 'template_done_id');
        });

        Schema::create('templates_folders', function (Blueprint $table) {
            $table->integer('folder_id', true);
            $table->text('folder_name');
            $table->text('folder_text');
            $table->integer('folder_added');
        });

        Schema::create('todo_list', function (Blueprint $table) {
            $table->integer('todo_id', true)->unique('todo_id');
            $table->text('todo_type');
            $table->text('todo_client');
            $table->text('todo_consultant');
            $table->string('todo_origin', 55);
            $table->text('todo_message');
            $table->text('todo_due');
            $table->integer('todo_done')->default(0);
            $table->text('todo_start');
            $table->integer('todo_hide')->default(0);
            $table->integer('todo_priority')->nullable()->default(0);
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->string('two_factor_secret')->nullable();
            $table->boolean('two_factor_enabled')->default(false);
        });

        Schema::create('will_with_probate', function (Blueprint $table) {
            $table->integer('wwp_id', true);
            $table->integer('probate_code');
            $table->integer('will_code');
            $table->integer('wwp_timestamp');
            $table->string('wwp_by', 100);

            $table->unique(['wwp_id'], 'wwp_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('will_with_probate');

        Schema::dropIfExists('users');

        Schema::dropIfExists('todo_list');

        Schema::dropIfExists('templates_folders');

        Schema::dropIfExists('templates_done');

        Schema::dropIfExists('templates');

        Schema::dropIfExists('subscriptions');

        Schema::dropIfExists('storage_box');

        Schema::dropIfExists('staff_holidays');

        Schema::dropIfExists('sessions');

        Schema::dropIfExists('sandbox_persons');

        Schema::dropIfExists('sandbox_clients');

        Schema::dropIfExists('sandbox_client_details');

        Schema::dropIfExists('record_changes');

        Schema::dropIfExists('quote');

        Schema::dropIfExists('query_logs');

        Schema::dropIfExists('qbo_tokens');

        Schema::dropIfExists('qbo_items');

        Schema::dropIfExists('qbo_invoice_request');

        Schema::dropIfExists('products');

        Schema::dropIfExists('probate_property');

        Schema::dropIfExists('probate_persons');

        Schema::dropIfExists('probate_deleted');

        Schema::dropIfExists('probate_clients');

        Schema::dropIfExists('probate_case_status');

        Schema::dropIfExists('probate_assets');

        Schema::dropIfExists('probate_admin_spreadsheet');

        Schema::dropIfExists('probate_acc_request_payment');

        Schema::dropIfExists('probate_acc_liabilities');

        Schema::dropIfExists('probate_acc_ledger');

        Schema::dropIfExists('probate_acc_distribution');

        Schema::dropIfExists('probate_acc_assets');

        Schema::dropIfExists('prefil_companies');

        Schema::dropIfExists('persons');

        Schema::dropIfExists('payments');

        Schema::dropIfExists('password_reset_tokens');

        Schema::dropIfExists('partners');

        Schema::dropIfExists('overseas_type_status');

        Schema::dropIfExists('overseas_persons');

        Schema::dropIfExists('overseas_mg');

        Schema::dropIfExists('overseas_clients');

        Schema::dropIfExists('overseas_assets');

        Schema::dropIfExists('misc_clients');

        Schema::dropIfExists('menus');

        Schema::dropIfExists('mc_lists');

        Schema::dropIfExists('marketing_letters');

        Schema::dropIfExists('marketing_emails');

        Schema::dropIfExists('login_logs');

        Schema::dropIfExists('leads_executors');

        Schema::dropIfExists('leads');

        Schema::dropIfExists('jobs');

        Schema::dropIfExists('job_batches');

        Schema::dropIfExists('failed_jobs');

        Schema::dropIfExists('email_templates');

        Schema::dropIfExists('earnings');

        Schema::dropIfExists('document_store');

        Schema::dropIfExists('consultants_list');

        Schema::dropIfExists('clients');

        Schema::dropIfExists('client_details');

        Schema::dropIfExists('chat_online');

        Schema::dropIfExists('chat_messages');

        Schema::dropIfExists('case_editing');

        Schema::dropIfExists('cache_locks');

        Schema::dropIfExists('cache');

        Schema::dropIfExists('api_calls');

        Schema::dropIfExists('amllogs');

        Schema::dropIfExists('aml_requests');

        Schema::dropIfExists('accounts_online');

        Schema::dropIfExists('accounts_extra');

        Schema::dropIfExists('accounts_copy');

        Schema::dropIfExists('accounts');

        Schema::dropIfExists('accounting');
    }
};
