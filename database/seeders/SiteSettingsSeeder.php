<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name',      'value' => 'BR MEP Solutions'],
            ['key' => 'phone',          'value' => '+1 (555) 000-0000'],
            ['key' => 'whatsapp',       'value' => '15550000000'],
            ['key' => 'email',          'value' => 'info@brmepsolutions.com'],
            ['key' => 'address',        'value' => 'United States'],
            ['key' => 'working_hours',  'value' => 'Monday - Saturday: 8AM - 8PM'],
            ['key' => 'hero_title',     'value' => 'Expert Plumbing & Maintenance in USA'],
            ['key' => 'hero_subtitle',  'value' => 'Fast, reliable, professional plumbing services for homes and businesses.'],
            ['key' => 'about_text',     'value' => 'We are MEP Solutions — a professional plumbing and maintenance company based in the USA. We provide fast, reliable, and high-quality services for residential and commercial properties.'],
            ['key' => 'auto_reply_enabled', 'value' => '1'],
            ['key' => 'auto_reply_subject', 'value' => \App\Mail\LeadAcknowledgement::DEFAULT_SUBJECT],
            ['key' => 'auto_reply_body',    'value' => \App\Mail\LeadAcknowledgement::DEFAULT_BODY],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
