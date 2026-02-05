@if($published ?? false)
    <span class="badge badge-approved">Published</span>
@else
    <span class="badge badge-draft">Draft</span>
@endif
@if(!($active ?? true))
    <i class="bi bi-eye-slash text-muted" title="Inactive"></i>
@endif
