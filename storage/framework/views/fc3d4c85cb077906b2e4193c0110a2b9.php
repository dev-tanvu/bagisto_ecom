<div class="flex flex-col">
    <p 
        class="font-semibold leading-6 text-gray-800 dark:text-white"
        v-text="'<?php echo e($address->name); ?>'"
    >
    </p>

    <p 
        class="!leading-6 text-gray-600 dark:text-gray-300"
        v-pre
    >
        <?php echo e($address->address); ?><br>

        <?php echo e($address->city); ?><br>

        <?php echo e(trans('admin::app.sales.orders.view.contact')); ?> : <?php echo e($address->phone); ?>

    </p>
</div><?php /**PATH D:\Frooxi new\Iqbal Project\NextOutfit\packages\Webkul\Admin\src/resources/views/sales/address.blade.php ENDPATH**/ ?>