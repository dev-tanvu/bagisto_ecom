<?php if (isset($component)) { $__componentOriginal3ad46025fb3e01e4c2eb9d1732f00674 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3ad46025fb3e01e4c2eb9d1732f00674 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'admin::components.layouts.anonymous','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin::layouts.anonymous'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> 
        <?php echo app('translator')->get('admin::app.users.sessions.title'); ?>
     <?php $__env->endSlot(); ?>

    
    <div class="flex min-h-screen bg-white" style="font-family:'Montserrat',sans-serif;">
        
        
        <div class="hidden lg:flex lg:w-1/2 bg-black flex-col justify-between p-12 xl:p-16">
            
            
            <div>
                <img
                    src="<?php echo e(asset('themes/shop/logo-gold.png')); ?>"
                    alt="<?php echo e(config('app.name')); ?>"
                    class="h-8 w-auto"
                >
            </div>

            
            <div>
                <span style="font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#9ca3af;margin-bottom:24px;display:block;">
                    Admin Portal
                </span>

                <h2 style="font-size:clamp(32px,4vw,48px);font-weight:400;line-height:1.1;letter-spacing:0.06em;text-transform:uppercase;color:#fff;margin:0 0 24px;font-family:'DM Serif Display',Georgia,serif;">
                    Manage your<br>store.
                </h2>

                <p style="font-size:14px;line-height:1.8;color:#9ca3af;max-w-md;margin:0;">
                    Control inventory, orders, customers, and analytics — all in one place.
                </p>

                <div style="width:48px;height:2px;background:#fff;margin-top:32px;"></div>
            </div>
        </div>

        
        <div class="flex-1 flex flex-col justify-center px-8 sm:px-12 lg:px-16 xl:px-24 py-12">
            <div class="w-full max-w-md mx-auto">
                
                
                <div class="lg:hidden mb-12">
                    <img
                        src="<?php echo e(asset('themes/shop/logo-gold.png')); ?>"
                        alt="<?php echo e(config('app.name')); ?>"
                        class="h-7 w-auto"
                    >
                </div>

                
                <div class="mb-12">
                    <p style="font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#9ca3af;margin:0 0 16px;">
                        Administrator
                    </p>
                    <h1 style="font-size:clamp(28px,3vw,36px);font-weight:400;letter-spacing:0.06em;text-transform:uppercase;color:#111;margin:0 0 8px;font-family:'DM Serif Display',Georgia,serif;">
                        <?php echo app('translator')->get('admin::app.users.sessions.title'); ?>
                    </h1>
                </div>

                
                <?php if (isset($component)) { $__componentOriginal81b4d293d9113446bb908fc8aef5c8f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal81b4d293d9113446bb908fc8aef5c8f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'admin::components.form.index','data' => ['action' => route('admin.session.store')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin::form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.session.store'))]); ?>

                    
                    <div style="margin-bottom:24px;">
                        <label style="font-family:'Montserrat',sans-serif;font-size:11px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#111;margin-bottom:8px;display:block;">
                            <?php echo app('translator')->get('admin::app.users.sessions.email'); ?>
                            <span style="color:#ef4444;margin-left:2px;">*</span>
                        </label>
                        <?php if (isset($component)) { $__componentOriginal7b1bc76a00ab5e7f1bf2c6429dae85a3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b1bc76a00ab5e7f1bf2c6429dae85a3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'admin::components.form.control-group.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin::form.control-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                            <?php if (isset($component)) { $__componentOriginal53af403f6b2179a3039d488b8ab2a267 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53af403f6b2179a3039d488b8ab2a267 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'admin::components.form.control-group.control','data' => ['type' => 'email','class' => '!rounded-lg !border-gray-200 !bg-white !px-4 !py-3.5 !text-sm focus:!border-black focus:!ring-1 focus:!ring-black transition-all','id' => 'email','name' => 'email','rules' => 'required|email','label' => trans('admin::app.users.sessions.email'),'placeholder' => trans('admin::app.users.sessions.email')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin::form.control-group.control'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'email','class' => '!rounded-lg !border-gray-200 !bg-white !px-4 !py-3.5 !text-sm focus:!border-black focus:!ring-1 focus:!ring-black transition-all','id' => 'email','name' => 'email','rules' => 'required|email','label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(trans('admin::app.users.sessions.email')),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(trans('admin::app.users.sessions.email'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53af403f6b2179a3039d488b8ab2a267)): ?>
<?php $attributes = $__attributesOriginal53af403f6b2179a3039d488b8ab2a267; ?>
<?php unset($__attributesOriginal53af403f6b2179a3039d488b8ab2a267); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53af403f6b2179a3039d488b8ab2a267)): ?>
<?php $component = $__componentOriginal53af403f6b2179a3039d488b8ab2a267; ?>
<?php unset($__componentOriginal53af403f6b2179a3039d488b8ab2a267); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal8da25fb6534e2ef288914e35c32417f8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8da25fb6534e2ef288914e35c32417f8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'admin::components.form.control-group.error','data' => ['controlName' => 'email']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin::form.control-group.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['control-name' => 'email']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8da25fb6534e2ef288914e35c32417f8)): ?>
<?php $attributes = $__attributesOriginal8da25fb6534e2ef288914e35c32417f8; ?>
<?php unset($__attributesOriginal8da25fb6534e2ef288914e35c32417f8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8da25fb6534e2ef288914e35c32417f8)): ?>
<?php $component = $__componentOriginal8da25fb6534e2ef288914e35c32417f8; ?>
<?php unset($__componentOriginal8da25fb6534e2ef288914e35c32417f8); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7b1bc76a00ab5e7f1bf2c6429dae85a3)): ?>
<?php $attributes = $__attributesOriginal7b1bc76a00ab5e7f1bf2c6429dae85a3; ?>
<?php unset($__attributesOriginal7b1bc76a00ab5e7f1bf2c6429dae85a3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7b1bc76a00ab5e7f1bf2c6429dae85a3)): ?>
<?php $component = $__componentOriginal7b1bc76a00ab5e7f1bf2c6429dae85a3; ?>
<?php unset($__componentOriginal7b1bc76a00ab5e7f1bf2c6429dae85a3); ?>
<?php endif; ?>
                    </div>

                    
                    <div style="margin-bottom:24px;position:relative;">
                        <label style="font-family:'Montserrat',sans-serif;font-size:11px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#111;margin-bottom:8px;display:block;">
                            <?php echo app('translator')->get('admin::app.users.sessions.password'); ?>
                            <span style="color:#ef4444;margin-left:2px;">*</span>
                        </label>
                        <?php if (isset($component)) { $__componentOriginal7b1bc76a00ab5e7f1bf2c6429dae85a3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b1bc76a00ab5e7f1bf2c6429dae85a3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'admin::components.form.control-group.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin::form.control-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                            <?php if (isset($component)) { $__componentOriginal53af403f6b2179a3039d488b8ab2a267 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53af403f6b2179a3039d488b8ab2a267 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'admin::components.form.control-group.control','data' => ['type' => 'password','class' => '!rounded-lg !border-gray-200 !bg-white !px-4 !py-3.5 !text-sm !pr-12 focus:!border-black focus:!ring-1 focus:!ring-black transition-all','id' => 'password','name' => 'password','rules' => 'required|min:6','label' => trans('admin::app.users.sessions.password'),'placeholder' => trans('admin::app.users.sessions.password')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin::form.control-group.control'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'password','class' => '!rounded-lg !border-gray-200 !bg-white !px-4 !py-3.5 !text-sm !pr-12 focus:!border-black focus:!ring-1 focus:!ring-black transition-all','id' => 'password','name' => 'password','rules' => 'required|min:6','label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(trans('admin::app.users.sessions.password')),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(trans('admin::app.users.sessions.password'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53af403f6b2179a3039d488b8ab2a267)): ?>
<?php $attributes = $__attributesOriginal53af403f6b2179a3039d488b8ab2a267; ?>
<?php unset($__attributesOriginal53af403f6b2179a3039d488b8ab2a267); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53af403f6b2179a3039d488b8ab2a267)): ?>
<?php $component = $__componentOriginal53af403f6b2179a3039d488b8ab2a267; ?>
<?php unset($__componentOriginal53af403f6b2179a3039d488b8ab2a267); ?>
<?php endif; ?>
                            <span
                                class="icon-view absolute top-[42px] right-4 text-2xl cursor-pointer text-gray-400 hover:text-black transition-colors"
                                id="visibilityIcon"
                                onclick="switchVisibility()"
                                role="presentation"
                                tabindex="0"
                            ></span>
                            <?php if (isset($component)) { $__componentOriginal8da25fb6534e2ef288914e35c32417f8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8da25fb6534e2ef288914e35c32417f8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'admin::components.form.control-group.error','data' => ['controlName' => 'password']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin::form.control-group.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['control-name' => 'password']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8da25fb6534e2ef288914e35c32417f8)): ?>
<?php $attributes = $__attributesOriginal8da25fb6534e2ef288914e35c32417f8; ?>
<?php unset($__attributesOriginal8da25fb6534e2ef288914e35c32417f8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8da25fb6534e2ef288914e35c32417f8)): ?>
<?php $component = $__componentOriginal8da25fb6534e2ef288914e35c32417f8; ?>
<?php unset($__componentOriginal8da25fb6534e2ef288914e35c32417f8); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7b1bc76a00ab5e7f1bf2c6429dae85a3)): ?>
<?php $attributes = $__attributesOriginal7b1bc76a00ab5e7f1bf2c6429dae85a3; ?>
<?php unset($__attributesOriginal7b1bc76a00ab5e7f1bf2c6429dae85a3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7b1bc76a00ab5e7f1bf2c6429dae85a3)): ?>
<?php $component = $__componentOriginal7b1bc76a00ab5e7f1bf2c6429dae85a3; ?>
<?php unset($__componentOriginal7b1bc76a00ab5e7f1bf2c6429dae85a3); ?>
<?php endif; ?>
                    </div>

                    
                    <div style="text-align:right;margin-bottom:32px;">
                        <a
                            href="<?php echo e(route('admin.forget_password.create')); ?>"
                            style="font-size:12px;font-weight:500;color:#111;text-decoration:none;letter-spacing:0.1em;text-transform:uppercase;"
                            onmouseover="this.style.color='#666'"
                            onmouseout="this.style.color='#111'"
                        >
                            <?php echo app('translator')->get('admin::app.users.sessions.forget-password-link'); ?>
                        </a>
                    </div>

                    
                    <button
                        type="submit"
                        style="width:100%;padding:14px 44px;background:#000;color:#fff;font-family:'Montserrat',sans-serif;font-size:13px;font-weight:500;border-radius:9999px;border:none;cursor:pointer;letter-spacing:0.2em;text-transform:uppercase;transition:all 0.2s;"
                        onmouseover="this.style.background='#333'"
                        onmouseout="this.style.background='#000'"
                        aria-label="<?php echo e(trans('admin::app.users.sessions.submit-btn')); ?>"
                    >
                        <?php echo app('translator')->get('admin::app.users.sessions.submit-btn'); ?>
                    </button>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal81b4d293d9113446bb908fc8aef5c8f6)): ?>
<?php $attributes = $__attributesOriginal81b4d293d9113446bb908fc8aef5c8f6; ?>
<?php unset($__attributesOriginal81b4d293d9113446bb908fc8aef5c8f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal81b4d293d9113446bb908fc8aef5c8f6)): ?>
<?php $component = $__componentOriginal81b4d293d9113446bb908fc8aef5c8f6; ?>
<?php unset($__componentOriginal81b4d293d9113446bb908fc8aef5c8f6); ?>
<?php endif; ?>

                
                <p style="font-size:11px;color:#9ca3af;text-align:center;margin-top:48px;letter-spacing:0.05em;">
                    <?php echo trans('admin::app.users.sessions.powered-by-description', [
                        'frooxi' => '<a style="color:#111;text-decoration:none;font-weight:600;" href="https://frooxi.com/en/">Frooxi</a>',
                        'webkul' => '<a style="color:#9ca3af;text-decoration:none;" href="https://webkul.com/">Webkul</a>',
                    ]); ?>

                </p>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            function switchVisibility() {
                var f = document.getElementById('password');
                var i = document.getElementById('visibilityIcon');
                f.type = f.type === 'password' ? 'text' : 'password';
                i.classList.toggle('icon-view-close');
            }
        </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3ad46025fb3e01e4c2eb9d1732f00674)): ?>
<?php $attributes = $__attributesOriginal3ad46025fb3e01e4c2eb9d1732f00674; ?>
<?php unset($__attributesOriginal3ad46025fb3e01e4c2eb9d1732f00674); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3ad46025fb3e01e4c2eb9d1732f00674)): ?>
<?php $component = $__componentOriginal3ad46025fb3e01e4c2eb9d1732f00674; ?>
<?php unset($__componentOriginal3ad46025fb3e01e4c2eb9d1732f00674); ?>
<?php endif; ?>
<?php /**PATH /Users/tasfirulhaque/Frooxi/Iqbal Hossen/bagisto_ecom/packages/Webkul/Admin/src/resources/views/users/sessions/create.blade.php ENDPATH**/ ?>