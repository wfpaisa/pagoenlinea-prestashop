{if $status == 'ok'}
<p>{l s='Your order on %s is complete.' sprintf=$shop_name mod='pagoenlinea'}
		<br /><br />
		{l s='Please send us a pago en linea with' mod='pagoenlinea'}
		<br /><br />- {l s='Amount' mod='pagoenlinea'} <span class="price"><strong>{$total_to_pay}</strong></span>
		<br /><br />- {l s='Name of account owner' mod='pagoenlinea'}  <strong>{if $pagoenlineaOwner}{$pagoenlineaOwner}{else}___________{/if}</strong>
		<br /><br />- {l s='Include these details' mod='pagoenlinea'}  <strong>{if $pagoenlineaDetails}{$pagoenlineaDetails}{else}___________{/if}</strong>
		<br /><br />- {l s='Bank name' mod='pagoenlinea'}  <strong>{if $pagoenlineaAddress}{$pagoenlineaAddress}{else}___________{/if}</strong>
		{if !isset($reference)}
			<br /><br />- {l s='Do not forget to insert your order number #%d in the subject of your pago en linea.' sprintf=$id_order mod='pagoenlinea'}
		{else}
			<br /><br />- {l s='Do not forget to insert your order reference %s in the subject of your pago en linea.' sprintf=$reference mod='pagoenlinea'}
		{/if}		<br /><br />{l s='An email has been sent with this information.' mod='pagoenlinea'}
		<br /><br /> <strong>{l s='Your order will be sent as soon as we receive payment.' mod='pagoenlinea'}</strong>
		<br /><br />{l s='If you have questions, comments or concerns, please contact our' mod='pagoenlinea'} <a href="{$link->getPageLink('contact', true)|escape:'html'}">{l s='expert customer support team' mod='pagoenlinea'}</a>.
	</p>
{else}
	<p class="warning">
		{l s='We noticed a problem with your order. If you think this is an error, feel free to contact our' mod='pagoenlinea'} 
		<a href="{$link->getPageLink('contact', true)|escape:'html'}">{l s='expert customer support team' mod='pagoenlinea'}</a>.
	</p>
{/if}
