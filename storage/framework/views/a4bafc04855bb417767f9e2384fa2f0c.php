<?php if (isset($component)) { $__componentOriginal2643b7d197f48caff2f606750db81304 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2643b7d197f48caff2f606750db81304 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'shop::components.layouts.index','data' => ['hasHeader' => true,'hasFeature' => false,'hasFooter' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('shop::layouts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['has-header' => true,'has-feature' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'has-footer' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
     <?php $__env->slot('title', null, []); ?> 
        Flash Sale
     <?php $__env->endSlot(); ?>

    <div style="min-height: 100vh; background: #fff; padding: 40px 16px 100px;">
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 40px;">
            <!-- Lightning bolt icon -->
            <div style="margin-bottom: 16px; display: inline-block;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13 2L4.5 13.5H11L10 22L20.5 10.5H14L13 2Z" fill="#14284a" stroke="#14284a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <!-- Heading -->
            <h1 style="font-size: 32px; font-weight: 400; letter-spacing: 0.1em; text-transform: uppercase; color: #14284a; margin: 0 0 8px 0; font-family: 'DM Serif Display', Georgia, serif; line-height: 1.2;">
                Flash Sale
            </h1>

            <!-- Subtext -->
            <p style="font-size: 14px; font-weight: 400; color: #6b7280; margin: 0; font-family: Montserrat, sans-serif;">
                Limited time offers on selected items
            </p>
        </div>

        <!-- Flash Sale Cards Grid -->
        <?php if($flashSaleItems->count() > 0): ?>
            <div id="flash-sale-grid" style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                <?php $__currentLoopData = $flashSaleItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($item->product ? '/' . $item->product->url_key : ($item->link ?? '#')); ?>" 
                       style="display: block; text-decoration: none; border-radius: 12px; overflow: hidden; background: #f9fafb; transition: transform 0.2s ease, box-shadow 0.2s ease;"
                       onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.1)'"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <!-- Card Image -->
                        <div style="position: relative; width: 100%; aspect-ratio: 9/16; overflow: hidden; background: #e5e7eb;">
                            <?php if($item->image_url): ?>
                                <img src="<?php echo e($item->image_url); ?>" 
                                     alt="<?php echo e($item->title ?? 'Flash Sale Item'); ?>" 
                                     loading="lazy"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13 2L4.5 13.5H11L10 22L20.5 10.5H14L13 2Z" fill="white" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            <?php endif; ?>

                            <!-- Badge Overlay -->
                            <?php if($item->title): ?>
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 100%); padding: 40px 16px 16px;">
                                    <h3 style="font-size: 16px; font-weight: 600; color: #fff; margin: 0 0 4px; font-family: Montserrat, sans-serif;">
                                        <?php echo e($item->title); ?>

                                    </h3>
                                    <?php if($item->subtitle): ?>
                                        <p style="font-size: 13px; color: rgba(255,255,255,0.9); margin: 0; font-family: Montserrat, sans-serif;">
                                            <?php echo e($item->subtitle); ?>

                                        </p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div style="text-align: center; padding: 80px 24px;">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-bottom: 24px;">
                    <path d="M13 2L4.5 13.5H11L10 22L20.5 10.5H14L13 2Z" fill="#d1d5db" stroke="#d1d5db" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h2 style="font-size: 24px; font-weight: 400; color: #6b7280; margin: 0 0 8px; font-family: 'DM Serif Display', Georgia, serif;">
                    No Flash Sales Available
                </h2>
                <p style="font-size: 14px; color: #9ca3af; margin: 0; font-family: Montserrat, sans-serif;">
                    Check back soon for exciting deals!
                </p>
            </div>
        <?php endif; ?>
    </div>

    <?php $__env->startPush('styles'); ?>
        <style>
            /* Mobile: 1 card per row with 9:16 ratio */
            @media (max-width: 768px) {
                #flash-sale-grid {
                    grid-template-columns: 1fr !important;
                    gap: 16px !important;
                }
            }

            /* Tablet: 2 cards per row */
            @media (min-width: 769px) and (max-width: 1024px) {
                #flash-sale-grid {
                    grid-template-columns: repeat(2, 1fr) !important;
                }
            }

            /* Desktop: 3-4 cards per row */
            @media (min-width: 1025px) {
                #flash-sale-grid {
                    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)) !important;
                }
            }
        </style>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2643b7d197f48caff2f606750db81304)): ?>
<?php $attributes = $__attributesOriginal2643b7d197f48caff2f606750db81304; ?>
<?php unset($__attributesOriginal2643b7d197f48caff2f606750db81304); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2643b7d197f48caff2f606750db81304)): ?>
<?php $component = $__componentOriginal2643b7d197f48caff2f606750db81304; ?>
<?php unset($__componentOriginal2643b7d197f48caff2f606750db81304); ?>
<?php endif; ?>

<?php /**PATH D:\Frooxi new\Iqbal Project\NextOutfit\packages\Webkul\Shop\src/resources/views/home/flash-sale.blade.php ENDPATH**/ ?>