'use strict';
const { useState } = React;
const appRoot = document.getElementById('fields_settings');

const SERVER_SCORING = crScoringEndpoint;

const ScoringFieldsSettingsComponent = () => {
  const [refresh, setRefresh] = useState(false);
  const [campaign, setCampaign] = useState('')

  return (
    <div className='container-fluid spark-screen'>
      <div className='row'>
        <div className='col-md-12'>
          <SelectCampaignComponent setCampaign={setCampaign} setRefresh={setRefresh} />
          <ScoringPanelConfigComponent setRefresh={setRefresh} campaign={campaign} />
          <ScoringSettingsTableComponent refresh={refresh} setRefresh={setRefresh} campaign={campaign} />
          <ScoringGroupValuesComponent setRefresh={setRefresh} campaign={campaign} />
        </div>
      </div>
    </div>
  );
};

const root = ReactDOM.createRoot(appRoot);
root.render(<ScoringFieldsSettingsComponent />);
