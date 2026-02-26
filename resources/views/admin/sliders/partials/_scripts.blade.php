<script>
    function sliderHandler() {
        return {
            openModal: false,
            editMode: false,
            imagePreview: null,
            formData: {
                id: '',
                title: '',
                order_priority: 0,
                is_active: 1,
                image: null
            },

            handleFileUpload(e) {
                const file = e.target.files[0];
                if (file) {
                    this.formData.image = file;
                    this.imagePreview = URL.createObjectURL(file);
                }
            },

            editSlider(slider) {
                this.resetForm();
                this.editMode = true;
                this.formData = {
                    ...slider,
                    image: null
                };
                this.imagePreview = `/storage/${slider.image_path}`;
                this.openModal = true;
            },


            async saveSlider() {
                let data = new FormData();
                data.append('title', this.formData.title || '');
                data.append('order_priority', this.formData.order_priority);
                data.append('is_active', this.formData.is_active);

                if (this.formData.image) {
                    data.append('image', this.formData.image);
                }

                let url = this.editMode ?
                    `/admin/sliders/update/${this.formData.id}` :
                    '{{ route('admin.sliders.store') }}';

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: data
                    });

                    const result = await response.json();

                    if (response.status === 200 || response.status === 201) {
                        location.reload();
                    } else if (response.status === 422) {
                        // Validation errors ko string mein convert karein
                        let errorMessages = Object.values(result.errors).flat().join('\n');
                        alert("Validation Errors:\n" + errorMessages);
                    } else {
                        alert('Error: ' + (result.message || 'Something went wrong'));
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Server Error: Connection failed');
                }
            },

            async deleteSlider(id) {
                if (!confirm('Are you sure?')) return;
                await fetch(`/admin/sliders/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                location.reload();
            },

            resetForm() {
                this.editMode = false;
                this.formData = {
                    id: '',
                    title: '',
                    order_priority: 0,
                    is_active: 1,
                    image: null
                };
                this.imagePreview = null;
            }
        }
    }
</script>
