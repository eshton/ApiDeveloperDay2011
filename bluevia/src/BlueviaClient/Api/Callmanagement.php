<?php
/**
 *
 * @category    opentel
 * @package     com.bluevia
 * @copyright   Copyright (c) 2010 Telefónica I+D (http://www.tid.es)
 * @author      Bluevia <support@bluevia.com>
 * @version     1.0
 *
 * BlueVia is a global iniciative of Telefonica delivered by Movistar and O2.
 * Please, check out http://www.bluevia.com and if you need more information
 * contact us at support@bluevia.com
 */

/*
 * PAYMENT, CANCEL_AUTHORIZATION, REFUND
 */



/**
 * Base class for Location API
 */
class BlueviaClient_Api_Callmanagement extends BlueviaClient_Api_Client_RPC {

    

    /**
    * Helper to determine current class' API Name
    * @return <string> API Name
    */
    protected function _getAPIName() {
        return 'CallManagement';
    }



    public function  __construct(BlueviaClient $unica) {
        parent::__construct($unica);
    }

    /**
     * This operation allows to request to set-up a call session between two
     * addresses, a first CallParticipant (“A-Party”) and
     * a second CallParticipant (“B-Party”), provided that the
     * invoking application is allowed to connect them.
     * @param BlueviaClient_Schemas_UserIdType $firstCallParticipant (R)
     *                  The address of the first participant, and if
     *                 supplied the second participant, involved in the call session
     * @param bool $changeMediaNotAllowed (R) If true, no call participant (user)
     *                  in the call will be permitted to change media type
     *                  during the call.
     * 
     * @param BlueviaClient_Schemas_UserIdType firstPartDispAddr (O) It contains the address of the
     *                  caller to be displayed in first participant handset
     * @param BlueviaClient_Schemas_UserIdType otherPartDispAddr (O) It contains the address of the caller
     *                  to be displayed in second and subsequently invited
     *                  participants handsets
     * @param $media, mediaType (O) equals to mediaInfo, which identifies one
     *                  or more media type(s) for the call, i.e. the media
     *                  type(s) to be applied to the participants in the
     *                  call session
     * @return <string> callSessionIdentifier
     */
    public function makeCallSession(
           BlueviaClient_Schemas_UserIdType $firstCallParticipant,
           $changeMediaNotAllowed,
           BlueviaClient_Schemas_UserIdType $secondCallParticipant = null,
           BlueviaClient_Schemas_UserIdType $firstPartDispAddr = null,
           BlueviaClient_Schemas_UserIdType $otherPartDispAddr = null,
           $media = null, $mediaType = null
            ) {
        
        $method = 'MAKE_CALL_SESSION';

          // check for required parameters
        $this->_checkParameter(
                array(
                    $firstCallParticipant,
                    $changeMediaNotAllowed
                ),
            "call Participant and changeMediaNotAllowed are required"
        );

        $params[0]['callParticipant'] = $firstCallParticipant;

        if (!empty($secondCallParticipant)) {
            $params[1]['callParticipant'] = $secondCallParticipant;
        }
        
             
        if (!empty($firstPartDispAddr)) {
            $params['firstParticipantDisplayedAddress'] = $firstPartDispAddr;
        }
        
        if (!empty($otherPartDispAddr)) {
            $params['otherParticipantsDisplayedAddres'] = $otherPartDispAddr;
        }

        if (!empty($media) && !empty($mediaType)) {
            $params['mediaInfo'] = $this->_getMediaInfo($media, $mediaType);
        }


        $params = array('makeCallSessionParams' => $params);
        
        $result = $this->_RPCRequest(                
                $method,
                $params
        );

        $result = $this->_simplifyResponse(
                $result,
                array('callSessionIdentifier')
        );
        
        return $result;        
        
    }


    /**
     * This operation allows to request to add a call participant to call

     * @param <type> $callSessionIdentifier
     * @param BlueviaClient_Schemas_UserIdType $callParticipant
     * @param string $media
     * @param string $mediaType
     * @return no Exceptions if OK
     */
    public function addCallParticipant(
            $callSessionIdentifier,
            BlueviaClient_Schemas_UserIdType $callParticipant,
            $media = null, $mediaType = null)
    {
        $method = 'ADD_CALL_PARTICIPANT';

         $this->_checkParameter(
                 array($callSessionIdentifier, $callParticipant),
                "callSessionId and callParticipant are required");

        $params = array(
            'callSessionIdentifier' => $callSessionIdentifier,
            'callParticipant' => $callParticipant,
        );

        if (!empty($media) && !empty($mediaType)) {
            $params['mediaInfo'] = $this->_getMediaInfo($media, $mediaType);
        }
        $params = array(
            'addCallParticipantParams' => $params
        );

        $result = $this->_RPCRequest(
                $method,
                $params
        );
        
        return $result;
    }

    /**
     * This operation enables a call transfer, effectively transferring a call
     * participant from one call session into another call session.
     * @param string $destCallSessId
     * @param string $srcCallSessId
     * @param BlueviaClient_Schemas_UserIdType $callParticipant
     * @return <type>
     */
    public function transferCallParticipant(
            $destCallSessId,
            $srcCallSessId,
            BlueviaClient_Schemas_UserIdType $callParticipant) {
        
        $method = 'TRANSFER_CALL_PARTICIPANT';

        $this->_checkParameter(
                 array($srcCallSessId, $destCallSessId, $callParticipant),
                "srcCallSessId, destCallSessId, callParticipant are required"
        );

        $params = array(
            'destinationCallSessionIdentifier' => $destCallSessId,
            'sourceCallSessionIdentifier' => $srcCallSessId,
            'callParticipant' => $callParticipant,
        );

        $params = array(
            'transferCallParticipantParams' => $params
        );

        $result = $this->_RPCRequest(
                $method,
                $params
        );

        return $result;
    }

    /**
     * This operation retrieves the current call participant status of the call
     * participant identified by call Participant, within the call session
     * identified by the Call Session Identifier.
     * @param <type> $callSessionId
     * @param BlueviaClient_Schemas_UserIdType $callParticipant
     */
    public function getCallParticipantInformation(
            $callSessionId,
            Unica_UserIdType $callParticipant) {
        $method = 'GET_CALL_PARTICIPANT_INFORMATION';

        $this->_checkParameter(
                 array($callSessionId, $callParticipant),
                "callSessionId and callParticipant are required"
        );

        $params = array(
            'callSessionIdentifier' => $callSessionId,
            'callParticipant' => $callParticipant,
        );

        $params = array(
            'getCallParticipantInformationParams' => $params
        );

        $result = $this->_RPCRequest(
                $method,
                $params
        );

        $result = $this->_simplifyResponse(
                $result,
                array('callParticipantInformation')
        );
        
        return $result;
    }

    /**
     * This operation retrieves the CallSession information regarding the
     * call session identified by CallSessionIdentifier parameter. The
     * information provided in the CallSession includes the call participant
     * information.
     * 
     * @param <type> $callSessionId
     * @return <type> 
     */
    public function getCallSessionInformation($callSessionId) {
        $method = 'GET_CALL_SESSION_INFORMATION';

        $this->_checkParameter(
                 array($callSessionId),
                "callSessionId is required"
        );

        $params = array(
            'callSessionIdentifier' => $callSessionId,            
        );

        $params = array(
            'getCallSessionInformationParams' => $params
        );

        $result = $this->_RPCRequest(
                $method,
                $params
        );

        $result = $this->_simplifyResponse(
                $result,
                array('callSessionInform')
        );

        return $result;
    }

    /**
     * This operation removes the call participant identified by CallParticipant
     * from the call session identified by CallSessionIdentifier, and implicitly
     * terminates that participants involvement in the call session.
     *
     * @param <type> $callSessionId
     * @param BlueviaClient_Schemas_UserIdType $callParticipant
     * @return <type>
     */
    public function deleteCallParticipant(
            $callSessionId,
            BlueviaClient_Schemas_UserIdType $callParticipant) {
        $method = 'DELETE_CALL_PARTICIPANT';

        $this->_checkParameter(
                 array($callSessionId, $callParticipant),
                "callSessionId and callParticipant are required"
        );

        $params = array(
            'callSessionIdentifier' => $callSessionId,
            'callParticipant' => $callParticipant,
        );

        $params = array(
            'deleteCallParticipantParams' => $params
        );

        $result = $this->_RPCRequest(
                $method,
                $params
        );

        return $result;
    }

    /**
     * This operation terminates the call session identified by
     * CallSessionIdentifier. The call to all participants is ended.
     *
     * @param string $callSessionId
     * @throws Unica_Exception_Parameters
     */
    public function endCallSession($callSessionId) {
        $method = 'END_CALL_SESSION';

        $this->_checkParameter(
                 array($callSessionId),
                "callSessionId is required"
        );

        $params = array(
            'callSessionIdentifier' => $callSessionId,            
        );

        $params = array(
            'deleteCallParticipantParams' => $params
        );

        $result = $this->_RPCRequest(
                $method,
                $params
        );

        return $result;
    }
    



    /**
     * Helper for generating media & mediatype structures
     * @param <type> $media
     * @param <type> $mediaType
     * @return <type>
     */
    protected function _getMediaInfo($media, $mediaType) {
        return array(
                'media' => $media,
                'mediaType' => $mediaType
        );
    }

    /**
     * Generates an RPC Request: Overriden parent method for setting endpoint
     * @param <type> $method
     * @param <type> $params
     * @return <type>
     */
    protected function _RPCRequest($method, $params = null) {
        return parent::_RPCRequest(
                'https://sdpref.hi.inet:8243/services/UNICA/RPC/CallManagement',
                $method,
                $params
        );
    }



}