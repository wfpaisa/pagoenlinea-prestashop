{capture name=path}
	<a href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html':'UTF-8'}" title="{l s='Go back to the Checkout' mod='pagoenlinea'}">{l s='Checkout' mod='pagoenlinea'}</a><span class="navigation-pipe">{$navigationPipe}</span>{l s='Pago-en-linea payment' mod='pagoenlinea'}
{/capture}

{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Order summary' mod='pagoenlinea'}</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if $nbProducts <= 0}
	<p class="warning">{l s='Your shopping cart is empty.' mod='pagoenlinea'}</p>
{else}

	<h3>{l s='Pago-en-linea payment' mod='pagoenlinea'}</h3>
	
	<form action="{$link->getModuleLink('pagoenlinea', 'validation', [], true)|escape:'html'}" method="post">
		
		<img src="{$this_path_bw}pagoenlinea.jpg" alt="{l s='Pago en línea' mod='pagoenlinea'}" width="86" height="49" style="float:left; margin: 0px 10px 5px 0px;" />
		
		<p style="margin-top:20px;">
			{l s='Total:' mod='pagoenlinea'}
			<span id="amount" class="price">{displayPrice price=$total}</span>
			{if $use_taxes == 1}
		    {l s='(tax incl.)' mod='pagoenlinea'}
		  {/if}
		</p>
		<p><b>{l s='Please confirm your order by clicking "I confirm my order".' mod='pagoenlinea'}</b></p>

		<p class="cart_navigation" id="cart_navigation">
			<input type="submit" value="{l s='I confirm my order' mod='pagoenlinea'}" class="exclusive_large" />
			{*<a href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html'}" class="button_large">{l s='Other payment methods' mod='pagoenlinea'}</a>*}
		</p>

	</form>
{/if}

