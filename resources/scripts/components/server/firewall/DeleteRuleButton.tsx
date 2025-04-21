import React, { useState } from 'react';
import { ServerContext } from '@/state/server';
import { Actions, useStoreActions } from 'easy-peasy';
import { ApplicationStore } from '@/state';
import { httpErrorToHuman } from '@/api/http';
import Button from '@/components/elements/Button';
import ConfirmationModal from '@/components/elements/ConfirmationModal';
import removeRule from '@/api/server/firewall/removeRule';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faTrash } from '@fortawesome/free-solid-svg-icons';

interface Props {
    ruleId: number;
    onDeleted: () => void;
}

export default ({ ruleId, onDeleted }: Props) => {
    const [ visible, setVisible ] = useState(false);
    const [ isLoading, setIsLoading ] = useState(false);

    const uuid = ServerContext.useStoreState(state => state.server.data!.uuid);

    const { addError, clearFlashes, addFlash } = useStoreActions((actions: Actions<ApplicationStore>) => actions.flashes);

    const onDelete = () => {
        setIsLoading(true);
        clearFlashes('server:firewall');

        removeRule(uuid, ruleId).then(() => {
            setIsLoading(false);
            setVisible(false);
            onDeleted();
            addFlash({ key: 'server:firewall', message: 'You\'ve successfully deleted the firewall rule.', type: 'success', title: 'Success' });
        }).catch(error => {
            setIsLoading(false);
            setVisible(false);
            onDeleted();
            addError({ key: 'server:firewall', message: httpErrorToHuman(error) });
        });
    };

    return (
        <>
            <ConfirmationModal
                visible={visible}
                title={'Delete firewall rule?'}
                buttonText={'Yes, delete rule'}
                onConfirmed={onDelete}
                showSpinnerOverlay={isLoading}
                onModalDismissed={() => setVisible(false)}
            >
                Are you sure you want to delete this rule?
            </ConfirmationModal>
            <Button color={'red'} size={'xsmall'} onClick={() => setVisible(true)}>
                <FontAwesomeIcon icon={faTrash} /> Delete
            </Button>
        </>
    );
};
