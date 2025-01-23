'use strict';

const { useState, useEffect } = React;

const Messages = ({ messages, type, showMessage, setShowMessage }) => {
  useEffect(() => {
    if (showMessage) {
      setTimeout(() => {
        setShowMessage(false);
      }, 5000);
    }
  }, [showMessage]);

  if (type === 'success') {
    return (
      showMessage && (
        <div className='alert alert-success alert-dismissible'>
          <button
            type='button'
            className='close'
            data-dismiss='alert'
            aria-hidden='true'
            onClick={() => {
              setShowMessage(false);
            }}
          >
            ×
          </button>
          <h4>
            <i className='icon fa fa-check'></i> Bien!
          </h4>
          {messages}
        </div>
      )
    );
  }

  if (type === 'warning') {
    return (
      showMessage && (
        <div className='alert alert-warning alert-dismissible'>
          <button
            type='button'
            className='close'
            data-dismiss='alert'
            aria-hidden='true'
            onClick={() => {
              setShowMessage(false);
            }}
          >
            ×
          </button>
          <h4>
            <i className='icon fa fa-warning'></i> Advertencia
          </h4>
          {messages}
        </div>
      )
    );
  }

  if (type === 'info') {
    return (
      showMessage && (
        <div className='alert alert-info alert-dismissible'>
          <button
            type='button'
            className='close'
            data-dismiss='alert'
            aria-hidden='true'
            onClick={() => {
              setShowMessage(false);
            }}
          >
            ×
          </button>
          <h4>
            <i className='icon fa fa-info'></i> Información
          </h4>
          {messages}
        </div>
      )
    );
  }

  if (type === 'danger') {
    return (
      showMessage && (
        <div className='alert alert-danger alert-dismissible'>
          <button
            type='button'
            className='close'
            data-dismiss='alert'
            aria-hidden='true'
            onClick={() => {
              setShowMessage(false);
            }}
          >
            ×
          </button>
          <h4>
            <i className='icon fa fa-ban'></i> Error!
          </h4>
          {messages}
        </div>
      )
    );
  }

  return <div></div>;
};
