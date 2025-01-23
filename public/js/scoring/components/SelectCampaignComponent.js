'use strict'

const { useState, useEffect } = React;

const SelectCampaignComponent = ({ setCampaign, setRefresh }) => {
  const [loading, setLoading] = useState(false);
  const [campaigns, setCampaigns] = useState([]);
  const [campaignSelected, setCampaignSelected] = useState('');

  const getCampaigns = async () => {
    const response = await fetch(`${SERVER_SCORING}/cr-master/campaign/get-all`, {
      method: 'GET',
      mode: 'cors',
    }).then((response) => response.json());
    setCampaigns(response);
  };

  useEffect(() => {
    const getData = async () => {
      setLoading(true);
      await getCampaigns();
      setLoading(false);
    };
    getData();
  }, []);

  return (
    <div className='box box-success box-solid'>
      <div className='box-body'>
        <div className='form-group'>
          <label htmlFor='campaign'>Campaigns</label>
          <select
            className='form-control'
            id='campaign'
            name='campaign'
            value={campaignSelected}
            required
            onChange={(e) => {
              setCampaignSelected(e.target.value);
              setCampaign(e.target.value);
              setRefresh(true);
            }}
          >
            <option value=''>Select a option</option>
            {campaigns.map((item) => (
              <option key={item} value={item}>
                {`${item}`.toUpperCase()}
              </option>
            ))}
          </select>
        </div>
      </div>
      {loading && (
        <div className='overlay'>
          <i className='fa fa-refresh fa-spin'></i>
        </div>
      )}
    </div>
  );
}
