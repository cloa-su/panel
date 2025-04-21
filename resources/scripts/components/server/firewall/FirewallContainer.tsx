import React, { useEffect, useState } from 'react';
import useSWR from 'swr';
import ServerContentBlock from '@/components/elements/ServerContentBlock';
import { ServerContext } from '@/state/server';
import useFlash from '@/plugins/useFlash';
import Spinner from '@/components/elements/Spinner';
import tw from 'twin.macro';
import TitledGreyBox from '@/components/elements/TitledGreyBox';
import { Field as FormikField, Form, Formik, FormikHelpers } from 'formik';
import Field from '@/components/elements/Field';
import Button from '@/components/elements/Button';
import { number, object, string } from 'yup';
import FormikFieldWrapper from '@/components/elements/FormikFieldWrapper';
import Select from '@/components/elements/Select';
import Label from '@/components/elements/Label';
import FlashMessageRender from '@/components/FlashMessageRender';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faNetworkWired } from '@fortawesome/free-solid-svg-icons';
import GreyRowBox from '@/components/elements/GreyRowBox';
import styled from 'styled-components/macro';
import getRules from '@/api/server/firewall/getRules';
import addRule from '@/api/server/firewall/addRule';
import DeleteRuleButton from '@/components/server/firewall/DeleteRuleButton';

const Code = styled.code`${tw`font-mono py-1 px-2 bg-neutral-900 rounded text-sm inline-block`}`;

export interface FirewallResponse {
    rules: any[];
    allocations: any[];
}

interface CreateValues {
    ip: string;
    allocation: number;
    priority: number;
    type: string;
}

export default () => {
    const uuid = ServerContext.useStoreState(state => state.server.data!.uuid);

    const { clearFlashes, clearAndAddHttpError, addFlash } = useFlash();
    const { data, error, mutate } = useSWR<FirewallResponse>([ uuid, '/firewall' ], key => getRules(key), {
        revalidateOnFocus: false,
    });

    const [ isSubmit, setSubmit ] = useState(false);

    useEffect(() => {
        if (!error) {
            clearFlashes('server:firewall');
        } else {
            clearAndAddHttpError({ key: 'server:firewall', error });
        }
    }, [ error ]);

    const submit = (values: CreateValues, { setSubmitting }: FormikHelpers<CreateValues>) => {
        clearFlashes('server:firewall');
        setSubmit(true);

        addRule(uuid, values.ip, values.allocation, values.priority, values.type).then(() => {
            setSubmit(false);
            setSubmitting(false);
            mutate();
            addFlash({ key: 'server:firewall', message: 'You\'ve successfully added the firewall rule.', type: 'success', title: 'Success' });
        }).catch((error) => {
            setSubmit(false);
            setSubmitting(false);
            mutate();
            clearAndAddHttpError({ key: 'server:firewall', error });
        });
    };

    return (
        <ServerContentBlock title={'Firewall'} css={tw`flex flex-wrap`}>
            <div css={tw`w-full`}>
                <FlashMessageRender byKey={'server:firewall'} css={tw`mb-4`} />
            </div>
            {!data ?
                (
                    <div css={tw`w-full`}>
                        <Spinner size={'large'} centered />
                    </div>
                )
                :
                (
                    <>
                        <div css={tw`w-full lg:w-8/12 mt-4 lg:mt-0`}>
                            <TitledGreyBox title={'Create Firewall Rule'}>
                                <div css={tw`px-1 py-2`}>
                                    <Formik
                                        onSubmit={submit}
                                        initialValues={{
                                            ip: '',
                                            allocation: data.allocations[0].id,
                                            priority: 1,
                                            type: 'allow',
                                        }}
                                        validationSchema={object().shape({
                                            ip: string().required(),
                                            allocation: number().required(),
                                            priority: number().required().min(1),
                                            type: string().required(),
                                        })}
                                    >
                                        <Form>
                                            <div css={tw`flex flex-wrap`}>
                                                <div css={tw`mb-6 w-full lg:w-1/2`}>
                                                    <Field
                                                        name={'ip'}
                                                        label={'Remote Ip'}
                                                    />
                                                </div>
                                                <div css={tw`mb-6 w-full lg:w-1/2 lg:pl-4`}>
                                                    <Label>Server Port</Label>
                                                    <FormikFieldWrapper name={'allocation'}>
                                                        <FormikField as={Select} name={'allocation'}>
                                                            {data.allocations.map((item, key) => (
                                                                <option key={key} value={item.id}>{item.port}</option>
                                                            ))}
                                                        </FormikField>
                                                    </FormikFieldWrapper>
                                                </div>
                                                <div css={tw`mb-6 w-full lg:w-1/2`}>
                                                    <Field
                                                        name={'priority'}
                                                        label={'Priority'}
                                                    />
                                                </div>
                                                <div css={tw`mb-6 w-full lg:w-1/2 lg:pl-4`}>
                                                    <Label>Type</Label>
                                                    <FormikFieldWrapper name={'type'}>
                                                        <FormikField as={Select} name={'type'}>
                                                            <option value={'allow'}>Allow</option>
                                                            <option value={'block'}>Block</option>
                                                        </FormikField>
                                                    </FormikFieldWrapper>
                                                </div>
                                            </div>
                                            <div css={tw`flex justify-end`}>
                                                <Button type={'submit'} disabled={isSubmit}>
                                                    Create
                                                </Button>
                                            </div>
                                        </Form>
                                    </Formik>
                                </div>
                            </TitledGreyBox>

                            {data.rules.length < 1 ?
                                <p css={tw`text-center text-sm text-neutral-400 pt-4 pb-4`}>
                                    There are no firewall rule for this server.
                                </p>
                                :
                                (data.rules.map((item, key) => (
                                    <GreyRowBox $hoverable={false} css={tw`flex-wrap md:flex-nowrap mt-2`} key={key}>
                                        <div css={tw`flex items-center w-full md:w-auto`}>
                                            <div css={tw`pl-4 pr-6 text-neutral-400`}>
                                                <FontAwesomeIcon icon={faNetworkWired} />
                                            </div>
                                            <div css={tw`mr-4 md:w-48 overflow-hidden`}>
                                                <Code>{item.ip}</Code>
                                                <Label>Remote IP</Label>
                                            </div>
                                            <div css={tw`w-16 md:w-32 overflow-hidden`}>
                                                <Code>{item.port}</Code>
                                                <Label>Server Port</Label>
                                            </div>
                                            <div css={tw`w-16 md:w-32 overflow-hidden`}>
                                                <Code>{item.type[0].toUpperCase()}{item.type.slice(1)}</Code>
                                                <Label>Type</Label>
                                            </div>
                                            <div css={tw`w-16 md:w-16 overflow-hidden`}>
                                                <Code>{item.priority}</Code>
                                                <Label>Priority</Label>
                                            </div>
                                        </div>
                                        <div css={tw`w-full md:flex-none md:w-40 md:text-center mt-4 md:mt-0 text-right ml-4`}>
                                            <DeleteRuleButton ruleId={item.id} onDeleted={() => mutate()} />
                                        </div>
                                    </GreyRowBox>
                                )))
                            }
                        </div>
                        <div css={tw`w-full lg:w-4/12 lg:pl-4`}>
                            <TitledGreyBox title={'Firewall Help'}>
                                <div css={tw`px-1 py-2`}>
                                    You can create / remove firewall rules to your server. (Block / Allow traffic from selected ip on selected port.)
                                </div>
                            </TitledGreyBox>
                        </div>
                    </>
                )
            }
        </ServerContentBlock>
    );
}
;
