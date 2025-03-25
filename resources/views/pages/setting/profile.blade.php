
    <form action="{{ route('admin.setting.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Use PUT method for updates -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Company Profile</h3>
            </div>
        <div class="card-body">
            <div class="row g-3">
                <!-- English Name -->
                <div class="col-md-6">
                    <label for="english_name" class="form-label">English Name</label>
                    <input type="text" class="form-control" id="english_name" name="english_name"
                        value="{{ old('english_name', $settings->english_name ?? '') }}" required>
                </div>

                <!-- Khmer Name -->
                <div class="col-md-6">
                    <label for="khmer_name" class="form-label">Khmer Name</label>
                    <input type="text" class="form-control" id="khmer_name" name="khmer_name"
                        value="{{ old('khmer_name', $settings->khmer_name ?? '') }}" required>
                </div>

                <!-- Phone -->
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                        value="{{ old('phone', $settings->phone ?? '') }}" required>
                </div>

                <!-- Gmail -->
                <div class="col-md-6">
                    <label for="gmail" class="form-label">Gmail</label>
                    <input type="text" class="form-control" id="gmail" name="gmail"
                        value="{{ old('gmail', $settings->gmail ?? '') }}" required>
                </div>

                <!-- Vattin Number -->
                <div class="col-md-6">
                    <label for="vattin_number" class="form-label">Vattin Number</label>
                    <input type="text" class="form-control" id="vattin_number" name="vattin_number"
                        value="{{ old('vattin_number', $settings->vattin_number ?? '') }}" required>
                </div>

                <!-- Tax -->
                <div class="col-md-6">
                    <label for="tax" class="form-label">Tax</label>
                    <input type="number" class="form-control" id="tax" name="tax"
                        value="{{ old('tax', $settings->tax ?? '') }}" required>
                </div>

                <!-- Copy Right Text -->
                <div class="col-12">
                    <label for="copyright" class="form-label">Copy Right Text</label>
                    <input type="text" class="form-control" id="copyright" name="copyright"
                        value="{{ old('copyright', $settings->copyright ?? '') }}" required>
                </div>

                <!-- Address -->
                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address', $settings->address ?? '') }}</textarea>
                </div>
            </div>
        </div>
    </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Company Logo</h3>
            </div>
            <div class="card-body">
                <div class="col-4">
                    <label for="web_header_logo" class="form-label">Company Logo</label>
                    <div class="preview">
                        @if ($settings->logo && file_exists(public_path('uploads/settings/' . $settings->logo)))
                            <img src="{{ asset('uploads/settings/' . $settings->logo) }}" alt="Logo" height="120px">
                        @else
                            <img src="{{ asset('uploads/settings/default_image.jpg') }}" alt="Logo" height="120px">
                        @endif
                    </div>
                    <input type="file" class="form-control" id="web_header_logo" name="web_header_logo" accept="image/*">
                </div>
            </div>
        </div>
        <div class="mb-3 me-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>



<!-- Logo Upload -->
{{-- <div class="card">
    <div class="card-header">
        <h3 class="card-title">Company Logo</h3>
    </div>
    <div class="card-body">
        <div class="col-4">
            <div class="form-group">
                <label for="web_header_logo">{{ __('Website head logo') }}</label>
                <div class="preview"> --}}
{{-- You can display the current logo here --}}
{{-- @if ($settings->logo && file_exists(public_path('uploads/business_settings/' . $settings->logo)))
                        <img src="{{ asset('uploads/business_settings/' . $settings->logo) }}" alt="" height="120px">
                    @else
                        <img src="{{ asset('images/no_image_available.jpg') }}" alt="" height="120px">
                    @endif --}}
{{-- </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile" name="web_header_logo">
                    <label class="custom-file-label" for="customFile">{{ __('Choose file') }}</label>
                </div>
            </div>
        </div>
    </div>
</div> --}}
