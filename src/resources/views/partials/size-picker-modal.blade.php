<div class="settings-modal" id="sizePickerModal" aria-hidden="true">
    <div class="settings-modal-content">
        <div class="settings-modal-header">
            <h2>Select size</h2>
            <button type="button" class="close-modal" data-size-modal-close aria-label="Close">&times;</button>
        </div>
        <p class="form-help" id="sizePickerProductName"></p>
        <div class="sizes-list" id="sizePickerList"></div>
        <p class="product-inline-warning" id="sizePickerWarning" hidden></p>
        <form id="sizePickerForm" method="POST" action="{{ route('basket.store') }}" class="form-stack" style="margin-top: 1rem;">
            @csrf
            <input type="hidden" name="product_id" id="sizePickerProductId">
            <input type="hidden" name="size_id" id="sizePickerSizeId">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-primary btn-full" id="sizePickerSubmit" disabled>Add to basket</button>
        </form>
    </div>
</div>
