<template x-if="showModal">
    <div
        style="position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; display:flex; align-items:center; justify-content:center; backdrop-filter: blur(4px);">
        <div
            style="width:100%; max-width:400px; background:var(--bg); border:1px solid var(--border); padding:25px; border-radius:20px;">
            <h2 style="color:var(--text); font-size:16px; font-weight:900; margin-bottom:20px;"
                x-text="isEdit ? 'Edit Step' : 'Add Step'"></h2>

            <form :action="isEdit ? `/admin/how-it-works/${formData.id}` : '{{ route('admin.how-it-works.store') }}'"
                method="POST" enctype="multipart/form-data">
                @csrf
                <template x-if="isEdit"><input type="hidden" name="_method" value="PATCH"></template>

                <div style="display:grid; gap:15px;">
                    <input type="number" name="step_order" x-model="formData.step_order" placeholder="Step Number"
                        required
                        style="width:100%; padding:12px; border-radius:10px; background:var(--card2); border:1px solid var(--border); color:var(--text);">

                    <input type="text" name="title" x-model="formData.title" placeholder="Title" required
                        style="width:100%; padding:12px; border-radius:10px; background:var(--card2); border:1px solid var(--border); color:var(--text);">

                    <textarea name="description" x-model="formData.description" placeholder="Description"
                        style="width:100%; padding:12px; border-radius:10px; background:var(--card2); border:1px solid var(--border); color:var(--text); min-height:80px;"></textarea>

                    <div style="display:flex; align-items:center; gap:10px;">
                        <div
                            style="width:50px; height:50px; background:var(--card2); border-radius:8px; overflow:hidden;">
                            <template x-if="formData.image_url"><img :src="formData.image_url"
                                    style="width:100%; height:100%; object-fit:cover;"></template>
                        </div>
                        <input type="file" name="image_path"
                            @change="formData.image_url = URL.createObjectURL($event.target.files[0])"
                            style="font-size:11px; color:var(--text3);">
                    </div>

                    <div style="display:flex; gap:10px;">
                        <button type="submit"
                            style="flex:2; background:var(--text); color:var(--bg); padding:12px; border-radius:12px; font-weight:900; border:none; cursor:pointer;">SAVE</button>
                        <button type="button" @click="showModal = false"
                            style="flex:1; background:var(--card2); color:var(--text); border:1px solid var(--border); border-radius:12px; cursor:pointer;">CANCEL</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
