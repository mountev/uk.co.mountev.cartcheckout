{crmRegion name="crm-cartcheckout-userdashboard-pre"}
{/crmRegion}
<div class="view-content">
  {if $cartcheckoutPaperRows}
    <table class="selector">
      <tr class="columnheader">
        <th>{ts}Date Purchased{/ts}</th>
        <th>{ts}Invoice Number{/ts}</th>
        <th>{ts}Paper Number{/ts}</th>
        <th>{ts}Paper(s){/ts}</th>
        <th></th>
      </tr>
      {counter start=0 skip=1 print=false}
      {foreach from=$cartcheckoutPaperRows item=row}
        <tr id='rowid{$row.id}' class=" crm-cartcheckout-paper-id_{$row.id} {cycle values="odd-row,even-row"}">
          <td class="crm-cartcheckout-paper-date">
               {$row.receive_date|crmDate}
          </td>
          <td class="crm-cartcheckout-paper-invoice-number">{$row.invoice_number}</td>
          <td class="crm-cartcheckout-paper-paper-number">{$row.paper_number}</td>
          <td class="crm-cartcheckout-paper-paper"><a href="{$row.paper_url}">{$row.paper}</a></td>
        </tr>
      {/foreach}
    </table>
  {else}
    <div class="messages status no-popup">
      <div class="icon inform-icon"></div>
      {ts}You do not have any purchased papers.{/ts}
    </div>
  {/if}
</div>
{crmRegion name="crm-cartcheckout-userdashboard-post"}
{/crmRegion}
