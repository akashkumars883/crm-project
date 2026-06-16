@extends('layouts.app')
@section('title', 'System Settings')

@section('content')
<div class="row mt-4 justify-content-center">
    <div class="col-lg-12">
        <h4 class="mb-4 fw-bold">System Settings</h4>

        @if(session('success'))
            <div class="alert alert-success shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="row g-0">
                <!-- Left Column: Vertical Tabs -->
                <div class="col-md-4 col-lg-3 border-end bg-light p-0">
                    <div class="nav flex-column nav-pills p-3" id="settings-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active fw-semibold mb-2" id="general-tab" data-bs-toggle="pill" href="#general" role="tab" aria-controls="general" aria-selected="true">
                            <i class="ti ti-building me-2"></i> General Settings
                        </a>
                        <a class="nav-link fw-semibold mb-2" id="smtp-tab" data-bs-toggle="pill" href="#smtp" role="tab" aria-controls="smtp" aria-selected="false">
                            <i class="ti ti-mail me-2"></i> Mail / SMTP
                        </a>
                        <a class="nav-link fw-semibold" id="api-tab" data-bs-toggle="pill" href="#api" role="tab" aria-controls="api" aria-selected="false">
                            <i class="ti ti-plug me-2"></i> API Integrations
                        </a>
                    </div>
                </div>

                <!-- Right Column: Tab Content -->
                <div class="col-md-8 col-lg-9 p-0 bg-white">
                    <div class="tab-content" id="settings-tabContent">
                        
                        <!-- General Settings Tab -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="p-4">
                                    <h5 class="fw-bold mb-4">Company Details</h5>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Company Name</label>
                                            <input type="text" class="form-control" name="company_name" value="{{ get_setting('company_name', 'Home Glazer') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Support Email</label>
                                            <input type="email" class="form-control" name="company_email" value="{{ get_setting('company_email', 'support@homeglazer.com') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" name="company_phone" value="{{ get_setting('company_phone') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Default Currency</label>
                                            <select class="form-select" name="currency">
                                                <option value="₹" {{ get_setting('currency') == '₹' ? 'selected' : '' }}>INR (₹)</option>
                                                <option value="$" {{ get_setting('currency') == '$' ? 'selected' : '' }}>USD ($)</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Company Address</label>
                                            <textarea class="form-control" name="company_address" rows="3">{{ get_setting('company_address') }}</textarea>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <label class="form-label">Company Logo</label>
                                            <div class="d-flex align-items-center gap-3">
                                                @if(get_setting('company_logo'))
                                                    <img src="{{ (\Illuminate\Support\Str::startsWith(get_setting('company_logo', 'http') ? get_setting('company_logo' : asset('storage/' . get_setting('company_logo'))) }}" alt="Logo" class="img-thumbnail" style="height: 60px; object-fit: contain;">
                                                @endif
                                                <input type="file" class="form-control" name="company_logo" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-light border-top p-3 text-end">
                                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Save General Settings</button>
                                </div>
                            </form>
                        </div>

                        <!-- Mail / SMTP Tab -->
                        <div class="tab-pane fade" id="smtp" role="tabpanel" aria-labelledby="smtp-tab">
                            <form action="{{ route('settings.update') }}" method="POST">
                                @csrf
                                <div class="p-4">
                                    <h5 class="fw-bold mb-4">SMTP Configuration</h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Mail Driver</label>
                                            <input type="text" class="form-control" name="mail_driver" value="{{ get_setting('mail_driver', 'smtp') }}" placeholder="smtp">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Mail Host</label>
                                            <input type="text" class="form-control" name="mail_host" value="{{ get_setting('mail_host', 'smtp.mailtrap.io') }}" placeholder="smtp.googlemail.com">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Mail Port</label>
                                            <input type="text" class="form-control" name="mail_port" value="{{ get_setting('mail_port', '2525') }}" placeholder="587">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Encryption</label>
                                            <input type="text" class="form-control" name="mail_encryption" value="{{ get_setting('mail_encryption', 'tls') }}" placeholder="tls / ssl">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" name="mail_username" value="{{ get_setting('mail_username') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" name="mail_password" value="{{ get_setting('mail_password') }}">
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label class="form-label">From Name</label>
                                            <input type="text" class="form-control" name="mail_from_name" value="{{ get_setting('mail_from_name', 'Home Glazer CRM') }}">
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label class="form-label">From Email</label>
                                            <input type="email" class="form-control" name="mail_from_address" value="{{ get_setting('mail_from_address', 'no-reply@homeglazer.com') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-light border-top p-3 text-end">
                                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Save SMTP Settings</button>
                                </div>
                            </form>
                        </div>

                        <!-- API Integrations Tab -->
                        <div class="tab-pane fade" id="api" role="tabpanel" aria-labelledby="api-tab">
                            <div class="p-4">
                                <h5 class="fw-bold mb-4">API Integrations</h5>
                                <p class="text-muted mb-4" style="font-size: 14px;">Use these credentials to connect external websites and forms to your CRM.</p>

                                <div class="row mb-4">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-semibold">Leads API Endpoint URL</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control bg-light" id="apiEndpoint" value="{{ url('/api/website-leads') }}" readonly>
                                            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('apiEndpoint')"><i class="ti ti-copy"></i> Copy</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Secret API Key (X-API-KEY)</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control bg-light" id="apiKey" value="hgak84j48h495hsnfu3bsknl" readonly>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('apiKey', this)"><i class="ti ti-eye"></i></button>
                                            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('apiKey')"><i class="ti ti-copy"></i> Copy</button>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4 text-muted">
                                <h6 class="fw-bold mb-3">Code Snippets (For Developers)</h6>
                                <ul class="nav nav-tabs mb-3" id="apiTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active fw-medium" id="php-tab" data-bs-toggle="tab" data-bs-target="#php" type="button" role="tab">PHP (cURL)</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fw-medium" id="js-tab" data-bs-toggle="tab" data-bs-target="#js" type="button" role="tab">JavaScript (Fetch)</button>
                                    </li>
                                </ul>
                                
                                <div class="tab-content" id="apiTabsContent">
                                    <!-- PHP Snippet -->
                                    <div class="tab-pane fade show active" id="php" role="tabpanel">
                                        <div class="position-relative">
<pre class="bg-dark text-light p-3 rounded" style="font-size: 13px;" id="phpCode">
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => '{{ url('/api/website-leads') }}',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode([
    "name" => "Customer Name",
    "email" => "customer@example.com",
    "phone" => "9876543210"
  ]),
  CURLOPT_HTTPHEADER => array(
    'X-API-KEY: hgak84j48h495hsnfu3bsknl',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
curl_close($curl);
echo $response;
</pre>
                                            <button class="btn btn-sm btn-light position-absolute top-0 end-0 m-2" onclick="copyToClipboard('phpCode', true)"><i class="ti ti-copy"></i> Copy</button>
                                        </div>
                                    </div>

                                    <!-- JS Snippet -->
                                    <div class="tab-pane fade" id="js" role="tabpanel">
                                        <div class="position-relative">
<pre class="bg-dark text-light p-3 rounded" style="font-size: 13px;" id="jsCode">
fetch("{{ url('/api/website-leads') }}", {
    method: "POST",
    headers: {
        "X-API-KEY": "hgak84j48h495hsnfu3bsknl",
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
        name: "Customer Name",
        email: "customer@example.com",
        phone: "9876543210"
    })
})
.then(response => response.json())
.then(result => console.log(result))
.catch(error => console.log('error', error));
</pre>
                                            <button class="btn btn-sm btn-light position-absolute top-0 end-0 m-2" onclick="copyToClipboard('jsCode', true)"><i class="ti ti-copy"></i> Copy</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(elementId, isInnerHtml = false) {
        let copyText;
        if(isInnerHtml) {
            copyText = document.getElementById(elementId).innerText;
        } else {
            let inputElement = document.getElementById(elementId);
            let originalType = inputElement.type;
            if (originalType === 'password') inputElement.type = 'text';
            copyText = inputElement.value;
            inputElement.type = originalType;
        }

        navigator.clipboard.writeText(copyText).then(function() {
            alert("Copied to clipboard!");
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    }

    function togglePassword(elementId, btn) {
        let input = document.getElementById(elementId);
        let icon = btn.querySelector('i');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('ti-eye');
            icon.classList.add('ti-eye-off');
        } else {
            input.type = "password";
            icon.classList.remove('ti-eye-off');
            icon.classList.add('ti-eye');
        }
    }
</script>
@endsection