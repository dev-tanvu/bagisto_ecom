<!-- Simplified Price Section: Base Price and Sale Price -->
<div class="grid gap-3">
    <!-- Base Price -->
    <x-admin::form.control-group>
        <x-admin::form.control-group.label>
            Base Price
        </x-admin::form.control-group.label>

        <x-admin::form.control-group.control
            type="price"
            name="price"
            rules="required"
            :value="old('price') ?: $product->price"
            label="Base Price"
        >
            <x-slot:currency>
                {{ core()->currencySymbol(core()->getBaseCurrencyCode()) }}
            </x-slot>
        </x-admin::form.control-group.control>

        <x-admin::form.control-group.error control-name="price" />
    </x-admin::form.control-group>

    <!-- Sale Price (Special Price) -->
    <x-admin::form.control-group>
        <x-admin::form.control-group.label>
            Sale Price
        </x-admin::form.control-group.label>

        <x-admin::form.control-group.control
            type="price"
            name="special_price"
            rules="nullable|numeric|min:0"
            :value="old('special_price') ?: $product->special_price"
            label="Sale Price"
        >
            <x-slot:currency>
                {{ core()->currencySymbol(core()->getBaseCurrencyCode()) }}
            </x-slot>
        </x-admin::form.control-group.control>

        <x-admin::form.control-group.error control-name="special_price" />
        
        <p class="mt-1 text-xs text-gray-500">
            Leave empty if product is not on sale
        </p>
    </x-admin::form.control-group>
</div>
